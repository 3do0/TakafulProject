@section('title')
المؤسسات الخيرية
@endsection

@section('PageCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/table/datatable/datatables.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/theme-checkbox-radio.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/forms/switches.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/table/datatable/custom_dt_custom.css') }}">

    @php
        $theme = session('theme', 'dark');
    @endphp

    @if ($theme === 'light')
        <link rel="stylesheet" type="text/css"
            href="{{ asset('assets/plugins/table/datatable/dt-global_style-light.css') }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/plugins/table/datatable/dt-global_style.css') }}">
    @endif
@endsection

<div class="mt-4">
    <div class="row">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="icon-pencil primary font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3>278</h3>
                                <span>New Posts</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="media d-flex">
                            <div class="align-self-center">
                                <i class="icon-speech warning font-large-2 float-left"></i>
                            </div>
                            <div class="media-body text-right">
                                <h3>156</h3>
                                <span>New Comments</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row layout-spacing mt-5">
        <div class="col-lg-12">
            <div class="statbox widget box box-shadow border rounded">
                <div class="widget-header px-4">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <h4 class="font-weight-semibold ">قائمة الجمعيات الخيريـة</h4>
                            <p class="text-sm">معرفة حميع المعلومات عن الجمعيات الخيرية المسجله لدى المنصة</p>
                        </div>
                        <div>
                            <a type="button"
                                class="btn btn-sm bg-transparent custom-btn-color btn-icon d-flex align-items-center  border border-white"
                                href="{{ route('org-form') }}" wire:navigate>
                                <span class="btn-inner--icon">
                                    <svg width="16" height="16" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24" fill="currentColor" class="d-block me-2">
                                        <path
                                            d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                        </path>
                                    </svg>
                                </span>
                                <span class="btn-inner--text ">أضافة جمعية جديدة</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="widget-content widget-content-area">
                    <div class="table-responsive overflow-hidden" wire:ignore>
                        <table id="style-1" class="table style-1">
                            <thead>
                                <tr class="text-nowrap">
                                    <th class="text-center checkbox-column"> Record no. </th>
                                    <th class="custom-btn-color">أسم المؤسسة</th>
                                    <th class="custom-btn-color">الشعار</th>
                                    <th class="text-center custom-btn-color">بيانات التواصل</th>
                                    <th class="custom-btn-color">موقع المؤسسـة</th>
                                    <th class="text-center custom-btn-color">نوع النشاط</th>
                                    <th class="text-center custom-btn-color"> رقم التسجيل</th>
                                    <th class="custom-btn-color ">البنك الذي تتعامل معة</th>
                                    <th class="custom-btn-color">رقم حساب البنك</th>
                                    <th class="custom-btn-color">ملف التصاريح</th>
                                    <th class="text-center custom-btn-color">رابط المؤسسـة</th>
                                    <th class="custom-btn-color">الحالــة</th>
                                    <th class="custom-btn-color">تاريخ الانشاء</th>
                                    <th class="custom-btn-color">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($organizations as $org)
                                    <tr>
                                        <td class="checkbox-column"> {{ $org->id }} </td>
                                        <td class="user-name">{{ $org->name }}</td>
                                        <td class="">
                                            @if ($org->logo)
                                                <a class="profile-img" href="{{ asset('storage/' . $org->logo) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('storage/' . $org->logo) }}" alt="شعار المؤسسة">
                                                </a>
                                            @else
                                                <a class="profile-img" href="../assets/img/id.jpg" target="_blank">
                                                    <img src="../assets/img/id.jpg" alt="شعار المؤسسة">
                                                </a>
                                            @endif
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm font-weight-semibold">{{ $org->email }}</h6>
                                                <h6 class="mb-0 text-sm font-weight-semibold">{{ $org->phone }}</h6>
                                            </div>
                                        </td>
                                        <td class="text-nowrap">
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="mb-0 text-sm">المـحـافـظـة :
                                                    <span
                                                        class="font-weight-semibold text-warning">{{ $org->city }}</span>
                                                </h6>
                                                <h6 class="mb-0 text-sm">الـحـي :
                                                    <span
                                                        class="font-weight-semibold text-warning">{{ $org->address }}</span>
                                                </h6>
                                            </div>
                                        </td>
                                        <td class="align-middle text-center text-sm ">
                                            @php
                                                $activities = explode(',', $org->activity_type);
                                            @endphp
                                            <div class="text-center"
                                                style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; max-width: 300px; margin: auto;">
                                                @foreach ($activities as $activity)
                                                    <span class="badge outline-badge-info">{{ $activity }}</span>
                                                @endforeach
                                            </div>

                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-sm font-weight-semibold">{{ $org->registration_number }}
                                            </h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-sm font-weight-semibold">{{ $org->bank_name }}</h6>
                                        </td>
                                        <td class="text-center">
                                            <h6 class="text-sm font-weight-semibold">{{ $org->bank_account_number }}
                                            </h6>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($org->license)
                                                <a href="{{ asset('storage/' . $org->license) }}" target="_blank"
                                                    class="btn btn-outline-info btn-rounded btn-sm">
                                                    عرض الملف
                                                </a>
                                            @else
                                                لا يوجد ملف
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ $org->web_url }}" class="btn btn-link bg-transparent"
                                                target="_blank">
                                                <h6 class="text-decoration-underline">{{ $org->web_url }}</h6>
                                            </a>
                                        </td>
                                        {{-- <td class="text-center"><span class="shadow-none badge badge-warning">Suspended</span></td> --}}
                                        <td class="align-middle text-center text-sm">
                                            <label class="switch s-icons s-outline s-outline-info mr-2">
                                                <input type="checkbox" role="switch" id="{{ $org->id }}"
                                                    wire:click="toggleStatus({{ $org->id }})"
                                                    {{ $org->approval_status ? 'checked' : '' }} />
                                                <span class="slider round"></span>
                                            </label>
                                        </td>
                                        <td class="align-middle text-center">
                                            <span
                                                class="text-warning text-sm font-weight-normal">{{ $org->created_at->format('Y-m-d') }}</span>
                                        </td>

                                        <td class="text-center">
                                            <a href="javascript:void(0);" data-toggle="tooltip" data-placement="top"
                                                title="" data-original-title="Edit"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-check-circle text-primary">
                                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                                                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                                                </svg></a></li>
                                            <a type="button" wire:click="confirmDelete({{ $org->id }})"
                                                data-toggle="tooltip" data-placement="top" title=""
                                                data-original-title="Delete"><svg xmlns="http://www.w3.org/2000/svg"
                                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    class="feather feather-x-circle text-danger">
                                                    <circle cx="12" cy="12" r="10"></circle>
                                                    <line x1="15" y1="9" x2="9"
                                                        y2="15"></line>
                                                    <line x1="9" y1="9" x2="15"
                                                        y2="15"></line>
                                                </svg></a></li>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/dataTables.buttons.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/jszip.min.js')}}"></script>    
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/buttons.html5.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/table/datatable/button-ext/buttons.print.min.js')}}"></script>
    <script>
        c1 = $('#style-1').DataTable({
            dom: '<"row"<"col-md-12"<"row"<"col-md-6"B><"col-md-6"f> > ><"col-md-12"rt> <"col-md-12"<"row"<"col-md-5"i><"col-md-7"p>>> >',
            buttons: {
                buttons: [
                    { extend: 'copy', className: 'btn' },
                    { extend: 'csv', className: 'btn' },
                    { extend: 'excel', className: 'btn' },
                    { extend: 'print', className: 'btn' }
                ]
            },
            headerCallback: function(e, a, t, n, s) {
                e.getElementsByTagName("th")[0].innerHTML =
                    '<label class="new-control new-checkbox checkbox-outline-info m-auto">\n<input type="checkbox" class="new-control-input chk-parent select-customers-info" id="customer-all-info">\n<span class="new-control-indicator"></span><span style="visibility:hidden">c</span>\n</label>'
            },
            columnDefs: [{
                targets: 0,
                width: "30px",
                className: "",
                orderable: !1,
                render: function(e, a, t, n) {
                    return '<label class="new-control new-checkbox checkbox-outline-info  m-auto">\n<input type="checkbox" class="new-control-input child-chk select-customers-info" id="customer-all-info">\n<span class="new-control-indicator"></span><span style="visibility:hidden">c</span>\n</label>'
                }
            }],
            "oLanguage": {
                "oPaginate": {
                    "sPrevious": '<svg xmlns="http://www.w3.request/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>',
                    "sNext": '<svg xmlns="http://www.w3.request/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>'
                },
                "sInfo": "Showing page _PAGE_ of _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.request/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "بحـث...",
                "sLengthMenu": "النتيجة :  _MENU_",
            },
            "lengthMenu": [5, 10, 20, 50],
            "pageLength": 5,
            "scrollX": true,
        });

        multiCheck(c1);
</script>
@endpush
