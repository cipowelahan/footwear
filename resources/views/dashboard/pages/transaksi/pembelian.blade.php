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
        Transaksi Pembelian
    </h1>
</section>

<section class="content">
    <div class="box">
        <div class="box-header with-border">
            <button type="button" class="btn btn-warning" onclick="resetTransaksi()">Reset</button>
            <button type="button" class="btn btn-primary" onclick="submitTransaksi()">Checkout</button>
        </div>

        <div class="box-body">
            <form>
                {{csrf_field()}}
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label" for="tanggal">Tanggal</label>
                            <input id="tanggal" name="tanggal" class="form-control" type="text" autocomplete="off">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="supplier_id">Supplier</label>
                            <select id="supplier" name="supplier_id" class="form-control">
                                <option value="">Pilih Supplier</option>
                                @foreach($supplier as $s)
                                <option value="{{$s->id}}">{{$s->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="total">Diskon (Nominal)</label>
                            <input id="diskon" class="form-control" type="text" value="0">
                            <input name="diskon" class="form-control" type="hidden" value="0">
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="total">Total</label>
                            <input id="total" class="form-control" type="text" readonly value="0">
                            <input name="total" class="form-control" type="hidden" value="0">
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <select id="produk" class="form-control">
                        </select>
                        <hr>
                        <div class="table-responsive">
                            <table class="table table-bordered" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Kode</th>
                                        <th>Nama</th>
                                        <th>Harga</th>
                                        <th style="width: 10%">Jumlah</th>
                                        <th>Total</th>
                                        <th style="width: 10%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="table-transaksi">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
        </div>

    </div>
</section>

<script>
    var thisPath = "{{request()->url()}}";
    var index_transaksi = 0;
    var exclude_produk = [];

    $('#supplier').select2({
        placeholder: 'Pilih Supplier'
    })

    $('#tanggal').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    }).datepicker('setDate', new Date())

    function toCurrency(num) {
        return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,')
    }

    function toNumber(text) {
        return parseInt(text.replace(/[,]+/g, ''))
    }

    function resetTransaksi() {
        index_transaksi = 0
        $('#tanggal').datepicker('setDate', new Date())
        $('#table-transaksi').empty()
        $('[name=total]').val('0')
        exclude_produk = []
    }

    function pilihProduk(item) {
        var template = `
            <tr id="tr-${index_transaksi}">
                <td>${item.kode}</td>
                <td>${item.nama}</td>
                <td style="text-align: right">${item.harga_beli_format}</td>
                <td><input id="tr-jumlah-${index_transaksi}" name="produk[${index_transaksi}][jumlah]" type="text" class="form-control" value="1" onkeyup="editJumlahProduk('${index_transaksi}')"></td>
                <td style="text-align: right" id="tr-total-${index_transaksi}">${item.harga_beli_format}</td>
                <td><button type="button" class="btn btn-danger" onclick="hapusProduk('${index_transaksi}')"><i class="fa fa-trash"></i></button></td>
                <input type="hidden" name="produk[${index_transaksi}][kode_produk]" value="${item.kode}">
                <input type="hidden" name="produk[${index_transaksi}][nama_produk]" value="${item.nama}">
                <input id="tr-produk-id-${index_transaksi}" type="hidden" name="produk[${index_transaksi}][produk_id]" value="${item.id}">
                <input id="tr-produk-stok-${index_transaksi}" type="hidden" value="${item.stok}">
                <input id="tr-produk-harga-${index_transaksi}" type="hidden" name="produk[${index_transaksi}][harga]" value="${item.harga_beli}">
                <input id="tr-produk-total-${index_transaksi}" type="hidden" name="produk[${index_transaksi}][total]" value="${item.harga_beli}">
                <input id="tr-produk-hpptemp-${index_transaksi}" type="hidden" value="${item.hpp}">
                <input id="tr-produk-hpp-${index_transaksi}" type="hidden" name="produk[${index_transaksi}][hpp]" value="${item.hpp}">
            </tr>
        `
        $('#table-transaksi').append(template)
        exclude_produk.push(item.id)
        index_transaksi += 1

        totalTransaksi()
    }

    function editJumlahProduk(index) {
        var stok, jumlah, harga, total, hpp
        jumlah = $(`#tr-jumlah-${index}`).val()
        stok = parseInt($(`#tr-produk-stok-${index}`).val())
        hpp = parseInt($(`#tr-produk-hpptemp-${index}`).val())

        jumlah = jumlah.replace(/[\D\s\._\-]+/g, "")
        jumlah = jumlah ? parseInt( jumlah, 10 ) : 0

        $(`#tr-jumlah-${index}`).val(jumlah)

        harga = parseInt($(`#tr-produk-harga-${index}`).val())
        total = jumlah * harga
        hpp = hpp * jumlah
        $(`#tr-total-${index}`).text(toCurrency(total))
        $(`#tr-produk-total-${index}`).val(total)
        $(`#tr-produk-hpp-${index}`).val(hpp)

        totalTransaksi()
    }

    function hapusProduk(index) {
        var produk_id = $(`#tr-produk-id-${index}`).val()
        var index_id = exclude_produk.indexOf(parseInt(produk_id))
        if (index_id > -1) exclude_produk.splice(index_id, 1)
        $(`#tr-${index}`).remove()

        totalTransaksi()
    }

    function totalProduk() {
        var sum = 0
        $("[id*='tr-produk-total']").each(function() {
            sum += parseInt($(this).val())
        })
        return sum
    }

    function totalTransaksi() {
        var sum, diskon

        sum = totalProduk()
        diskon = parseInt($('[name=diskon]').val())
        sum -= diskon

        $('#total').val(toCurrency(sum))
        $('[name=total]').val(sum)
    }

    function submitTransaksi() {
        $('form').submit()
    }

    $(function() {

        $('form').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            bootbox.confirm('Anda yakin ?', function(ok) {
                if (ok) {
                    routeMenu('post', thisPath, data, function(result) {
                        if (result == "1") {
                            routeMenu('get', thisPath);
                            notification('berhasil', 'success');
                        }
                        loader('hide')
                    });

                }
            })
        })

        $('#produk').select2({
            placeholder: "------- Pilih Produk -------",
            escapeMarkup: function(markup) {
                return markup
            },
            templateResult: function(data) {
                return data.html
            },
            ajax: {
                url: '{{route('produk.ajax')}}',
                data: function(params) {
                    var query = {
                        search: params.term,
                        exclude: exclude_produk.join(','),
                        page: params.page || 1
                    }
                    return query
                },
                processResults: function(data) {
                    var response

                    response = data.data.map(function(item) {
                            return {
                                id: item.id,
                                text: `${item.kode} | ${item.nama}`,
                                html: `<div class="row">` +
                                    `<div class="col-sm-4"><img src="{{asset('public')}}/${item.foto}" class="img-thumbnail"></div>` +
                                    `<div class="col-sm-8">` +
                                    `<strong>Kode</strong> : ${item.kode} <br>` +
                                    `<strong>Nama</strong> : ${item.nama} <br>` +
                                    `<strong>Kategori</strong> : ${item.kategori.nama} <br>` +
                                    `<strong>Harga</strong> : ${item.harga_beli_format} <br>` +
                                    `<strong>Stok</strong> : ${item.stok}` +
                                    `</div></div>`,
                                item: item
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

        $('#produk').on('select2:select', function(e) {
            var selectedProduk = $('#produk').select2('data')[0].item
            pilihProduk(selectedProduk)
            $('#produk').val(null).trigger('change')
        })

        $('#diskon').keyup(function(e) {
            if ( $.inArray( e.keyCode, [38,40,37,39] ) !== -1 ) {
                return
            }

            var input = $(this).val()
            input = input.replace(/[\D\s\._\-]+/g, "")
            input = input ? parseInt( input, 10 ) : 0

            var total = totalProduk()

            if (input > total) {
                bootbox.alert('Nilai Diskon Melebihi Total Transaksi')
                input = total
            } 

            $(this).val((input === 0) ? "0" : input.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,'))
            $('[name=diskon]').val(input)

            totalTransaksi()
        })
        
    })
</script>