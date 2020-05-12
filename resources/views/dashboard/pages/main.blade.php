<section class="content-header">
    <h1>
        Dashboard
    </h1>
</section>

<section class="content">
    <div class="row">
        <div class="col-sm-3">
            <img src="{{asset('public/assets/image/endar.jpg')}}" alt="">
        </div>
        <div class="col-sm-3">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Modal</span>
                    <span class="info-box-number">Rp {{$info->modal_format}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="col-sm-3">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-money"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Kas</span>
                    <span class="info-box-number">Rp {{$info->kas_format}}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
    </div>
    {{-- <div class="box">
        <div class="box-body">
            <p class="text-center">
                
                <span style="font-size: 16pt; font-weight: bold">
                    <img src="{{asset('public/assets/image/endar.jpg')}}" alt="">
                </span>
                
            </p>
            
        </div>
    </div> --}}
</section>