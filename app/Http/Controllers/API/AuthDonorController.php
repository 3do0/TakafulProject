<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Donor;
use App\Mail\OTPMail;


use Illuminate\Database\QueryException;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;



class AuthDonorController extends Controller
{
    public function store(Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:donors',
                'phone' => 'nullable|string|unique:donors',
                'password' => 'required|min:6',
                'gender' => 'required|in:male,female,ذكر,انثى',
                'country' => 'required|string',
            ]);


            $otp = rand(100000, 999999);
            $expiresAt = now()->addMinutes(10);


            try {
                Mail::to($request->email)->send(new OTPMail($otp));
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'فشل إرسال رمز التحقق، يرجى التحقق من الاتصال بالإنترنت ثم المحاولة مرة أخرى.',
                    'error' => $e->getMessage()
                ], 500);
            }


            $donor = Donor::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
                'gender' => $request->gender,
                'country' => $request->country,
                'otp' => $otp,
                'otp_expires_at' => $expiresAt,
            ]);

            return response()->json([
                'message' => 'تم إرسال رمز التحقق إلى البريد الإلكتروني.',
                'status' => true,
                'Donor' => [
                    'id' => $donor->id,
                    'name' => $donor->name,
                    'email' => $donor->email,
                    'phone' => $donor->phone,
                    'gender' => $donor->gender,
                    'country' => $donor->country,
                    'created_at' => $donor->created_at,
                    'updated_at' => $donor->updated_at,
                ]
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'حدث خطأ في التحقق من البيانات',
                'status' => false,
                'errors' => $e->errors()
            ], 422);
        } catch (QueryException $e) {
            return response()->json([
                'status' => false,
                'message' => 'المستخدم مسجل مسبقًا أو هناك خطأ في قاعدة البيانات'
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'حدث خطأ غير متوقع، يرجى المحاولة لاحقًا',
                'status' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {

        try {
            $validated = $request->validate([
                'email' => 'required|email',
                'otp' => 'required|numeric',
                'password' => 'required|min:6',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'خطأ في التحقق من البيانات.',
                'errors' => $e->errors()
            ], 422);
        }


        $donor = Donor::where('email', $validated['email'])
            ->where('otp', $validated['otp'])
            ->first();

        if (!$donor) {
            return response()->json([
                'status' => false,
                'message' => 'رمز التحقق أو البريد الإلكتروني غير صحيح.'
            ], 400);
        }


        $donor->password = Hash::make($validated['password']);
        $donor->otp = null;
        $donor->is_verified = true;
        $donor->save();

        return response()->json([
            'status' => true,
            'message' => 'تم تأكيد الحساب وتعيين كلمة المرور بنجاح.'
        ], 200);
    }

    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            $donor = Donor::where('email', $request->email)->first();

            if (!$donor || !Hash::check($request->password, $donor->password)) {
                return response()->json([
                    'status' => false,
                    'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
                ], 401);
            }

            if (!$donor->is_verified) {
                return response()->json([
                    'status' => false,
                    'message' => 'الحساب غير مفعل. يرجى التحقق من البريد الإلكتروني.',
                ], 403);
            }


            $token = $donor->createToken('donor-token')->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'تم تسجيل الدخول بنجاح.',
                'token' => $token,
                'donor' => $donor
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء تسجيل الدخول.',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function resetPasswordWithOtp(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'otp' => 'required|numeric',
                'password' => 'required|string|min:6|confirmed',
            ]);

            $donor = Donor::where('email', $request->email)
                ->where('otp', $request->otp)
                ->first();

            if (!$donor) {
                return response()->json([
                    'status' => false,
                    'message' => 'رمز التحقق أو البريد الإلكتروني غير صحيح.'
                ], 400);
            }

            if (now()->gt($donor->otp_expires_at)) {
                return response()->json([
                    'status' => false,
                    'message' => 'انتهت صلاحية رمز التحقق.'
                ], 400);
            }

            $donor->password = Hash::make($request->password);
            $donor->otp = null;
            $donor->otp_expires_at = null;
            $donor->save();

            return response()->json([
                'status' => true,
                'message' => 'تم إعادة تعيين كلمة المرور بنجاح.'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'خطأ في التحقق من البيانات.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ غير متوقع.',
                'error' => $e->getMessage()
            ], 500);
        }
    }





    public function sendOtpToResetPassword(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $donor = Donor::where('email', $request->email)->first();

            if (!$donor) {
                return response()->json([
                    'status' => false,
                    'message' => 'لا يوجد مستخدم مسجل بهذا البريد الإلكتروني.'
                ], 404);
            }

            $otp = rand(100000, 999999);
            $donor->otp = $otp;
            $donor->otp_expires_at = now()->addMinutes(10);
            $donor->save();

            Mail::to($request->email)->send(new OTPMail($otp));

            return response()->json([
                'status' => true,
                'message' => 'تم إرسال رمز التحقق لإعادة تعيين كلمة المرور.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء إرسال رمز التحقق.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json([
            'message' => 'logout successful'
        ]);
    }
}
