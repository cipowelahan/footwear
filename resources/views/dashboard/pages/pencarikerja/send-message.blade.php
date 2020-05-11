<style>
    .select2 {
        width: 100%!important;
    }
    
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #000000;
    }
</style>

<section class="content-header">
    <h1>
        Kirim Pesan SMS Pencari Kerja
        <small>Kirim Pesan SMS Pencari Kerja</small>
    </h1>
</section>

<section class="content">
    <div class="box">

        <form class="form-horizontal" method="POST" action="{{request()->url()}}" target="blank">
            <div class="box-body">
                {{csrf_field()}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">Pilih Berdasarkan</label>
                    <div class="col-sm-5">
                        <select id="choicesKontak" name="choices" class="form-control">
                            <option value="all">Pilih Semua</option>
                            <option value="date">Berdasarkan Tanggal Pendaftaran</option>
                            <option value="one">Pilih Satu - Satu</option>
                        </select>
                    </div>
                </div>
                <div class="form-group" id="selectKontakDate" style="display: none">
                    <label class="col-sm-2 control-label" for="tanggal_pendaftaran">Pilih Tanggal</label>
                    <div class="col-sm-5">
                        <select id="tanggal_pendaftaran" name="tanggal_pendaftaran" class="form-control">
                            @foreach($tanggal_pendaftaran as $tanggal)
                            <option value="{{$tanggal}}">{{$tanggal}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group" id="selectKontakOne" style="display: none">
                    <label class="col-sm-2 control-label" for="kontak[]">Pilih Kontak</label>
                    <div class="col-sm-5">
                        <select id="kontak" name="kontak[]" class="form-control" multiple="multiple">
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="pesan">Pesan</label>
                    <div class="col-sm-5">
                        <textarea name="pesan" rows="4" class="form-control" onkeyup="counterPesan(this)" maxlength="160"></textarea>
                        <p class="help-block">Maksimal 160 Karakter (<span id="counter">0</span>/160)</p>
                    </div>
                </div>
            </div>

            <div class="box-footer">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for=""></label>
                    <div class="col-sm-5">
                        <button class="btn btn-primary" type="submit">Download (.json)</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    var thisPath = "{{request()->url()}}";

    function counterPesan(val) {
        var length = val.value.length
        $('#counter').text(length)
    }

    $(function() {
        $('#tanggal_pendaftaran').select2()

        $('#kontak').select2({
            ajax: {
                url: thisPath + '/search',
                data: function(params) {
                    var query = {
                        search: params.term,
                        page: params.page || 1
                    }
                    return query
                },
                processResults: function(data) {
                    var response

                    response = data.data
                        .filter(function(item) {
                            return item.kontak != ""
                        })
                        .map(function(item) {
                            return {
                                id: `${item.nama}|${item.kontak}`,
                                text: `${item.nama} (${item.kontak})`,
                                exclude_id: item.id
                            }
                        })

                    return {
                        results: response,
                        pagination: {
                            more: (data.current_page == data.last_page) ? null : data.current_page + 1
                        }
                    }
                }
            }
        })

        $('#choicesKontak').change(function() {
            var selectChoices = $(this).val()

            if (selectChoices == 'all') {
                $('#selectKontakDate').hide()
                $('#selectKontakOne').hide()
            }
            else if (selectChoices == 'date') {
                $('#selectKontakDate').show()
                $('#selectKontakOne').hide()
            }
            else {
                $('#selectKontakDate').hide()
                $('#selectKontakOne').show()
            }
        })

        // $('#all').click(function(e) {
        //     if ($(this).is(':checked')) {
        //         $.ajax({
        //             url: thisPath + '/search?all=true',
        //             type: 'get',
        //             success: function(result) {
        //                 var data
        //                 data = result.map(function(item) {
        //                     return {
        //                         id: `${item.nama}|${item.kontak}`,
        //                         text: `${item.nama} (${item.kontak})`,
        //                         exclude_id: item.id
        //                     }
        //                 })
                        
        //                 data.forEach(function(item) {
        //                     $('#kontak').append(new Option(item.text, item.id, false, true)).trigger('change')
        //                 })
        //             },
        //             error: function(result) {
        //                 notification('gagal mengambil semua data', 'error')
        //             }
        //         })
        //     }
        //     else {

        //     }
        // })
    })
</script>