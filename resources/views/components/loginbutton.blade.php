@if ($enable ?? true)
    <div class="d-flex flex-column justify-content-center">
        <style>
            .hr-sect {
                display: flex;
                flex-direction: row;
            }

            .hr-sect:before,
            .hr-sect:after {
                content: "";
                flex: 1 1;
                border-bottom: 1px solid #cacaca;
                margin: auto;
            }

            .hr-sect:before {
                margin-right: 10px
            }

            .hr-sect:after {
                margin-left: 10px
            }
        </style>
        <div class="hr-sect my-3">atau log masuk melalui</div>
        <div class="d-grid col-12 mx-auto">

            <button type="button" class="btn btn-outline-warning" onclick="window.location.href='{{ $url }}'">
                <div class="d-flex align-items-center">
                    <div class="icon p-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="currentColor"
                            class="bi bi-shield-lock-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M8 0c-.69 0-1.843.265-2.928.56-1.11.3-2.229.655-2.887.87a1.54 1.54 0 0 0-1.044 1.262c-.596 4.477.787 7.795 2.465 9.99a11.8 11.8 0 0 0 2.517 2.453c.386.273.744.482 1.048.625.28.132.581.24.829.24s.548-.108.829-.24a7 7 0 0 0 1.048-.625 11.8 11.8 0 0 0 2.517-2.453c1.678-2.195 3.061-5.513 2.465-9.99a1.54 1.54 0 0 0-1.044-1.263 63 63 0 0 0-2.887-.87C9.843.266 8.69 0 8 0m0 5a1.5 1.5 0 0 1 .5 2.915l.385 1.99a.5.5 0 0 1-.491.595h-.788a.5.5 0 0 1-.49-.595l.384-1.99A1.5 1.5 0 0 1 8 5" />
                        </svg>
                    </div>
                    <div class="flex-grow-1 d-flex flex-column ">
                        <div class="lh-1 text-dark">Sistem iLogin</div>
                        <div class="lh-1 fst-italic fw-lighter text-dark"><small>Single sign-on
                                (SSO)</small></div>
                    </div>
                </div>
            </button>

        </div>
    </div>
@endif
