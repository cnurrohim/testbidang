<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Form Mutasi Barang</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    <style>
        .select2-selection__rendered {
            line-height: calc(1.5em + .75rem + 2px) !important;
        }
        .select2-container .select2-selection--single {
            height: calc(1.5em + .75rem + 2px) !important;
        }
        .select2-selection__arrow {
            height: calc(1.5em + .75rem + 2px) !important;
        }
    </style>
</head>

<body>
    <div class="container mt-2  mb-4">
        

        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left mb-2">
                    <h2>Mutasi Barang</h2>
                </div>
                <hr/>
                <div class="pull-right mb-4 mt-5">
                    <a class="" href="{{ route('mutasibarang.index') }}"> Kembali</a>
                </div>
            </div>
        </div>
        @if(session('status'))
        <div class="alert alert-success mb-1 mt-1">
            {{ session('status') }}
        </div>
        @endif
        
        <form action="{{ route('mutasibarang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label text-left">No. Bukti:</label>
                        <div class="col-sm-5">
                            <input type="text" name="noBukti" class="form-control" placeholder="No. Bukti" value="{{ old('noBukti') }}">
                        </div>
                        @error('noBukti')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal Mutasi:</label>
                        <div class="col-sm-5">
                            <input type="date" name="tanggal" class="form-control" placeholder="Tanggal Mutasi"  value="{{ old('tanggal', $currentDate) }}">
                        </div>
                        @error('tanggal')
                            <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>  

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Status Barang:</label>
                        <div class="col-sm-5">
                            <select class="form-control" name="isMasuk">
                                @foreach ($statusBarang as $key => $status)
                                    <option value="{{ $key }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('isMasuk')
                        <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
            


            <div id="formMutasiBarang" class="row mt-5">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="">Kode Barang</label>
                            </div>
                            <select class="autocompletebarang form-control" style="height: 100%" id="selectedKodeBarang"></select>
                            <div class="input-group-prepend">
                                <span class="input-group-text">Quantity</label>
                            </div>
                            <input type="number"  id="selectedQuantity" class="form-control" placeholder="Qty"  value="0">
                            <button class="btn btn-outline-primary" id="tambahbarang"> mutasi barang</button>
                            

                            @error('kodeBarang')
                                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                
                
            </div>

            <div class="row mt-4 mb-4">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Barang</th>
                            <th>Quantity</th>
                            <th>Action</th>
                        </tr>
                        <tbody id="listBarang">
                            @if (old('idBarang'))
                                @foreach (old('idBarang') as $key => $status)
                                    <tr>
                                        <td>{{ $key+1 }} <input type="hidden" name="idBarang[]" value="{{ old('idBarang.'.$key) }}" /> </td>
                                        <td>{{old('namaBarang.'.$key)}} <input type="hidden" name="namaBarang[]" value="{{ old('namaBarang.'.$key) }}"/></td>
                                        <td><input type="text" name="quantity[]" value="{{ old('quantity.'.$key) }}"/></td>
                                        <td><button class="btn btn-danger" onclick="(e) => hapusBaris(e,val)">-</button></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr id="empty-row">
                                    <td colspan="4" class="center text-center"> belum ada barang yang ditambahkan </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit" class="btn btn-primary ml-3">Tambahkan Mutasi</button>
        </form>
    </div>
</body>

<script type="text/javascript">

    document.querySelector('#tambahbarang').onclick = function(e){
        e.preventDefault();
        
        const val = getSelectedBarangValue();
        
        if(val){
            const numberCell = inserIntoCell([createRowNumber(),createInputKodeBarang()]);
            const inputNamaBarangCell = inserIntoCell([createTextNamaBarang(), createInputNamaBarang()]);
            const inputQuantityCell = inserIntoCell(createInputQuantity());
            const buttonHapusCell = inserIntoCell(createRemoveSelectedPlaceholderButton());

            const container = createSelectedPlaceholder();

            container.appendChild(numberCell);
            container.appendChild(inputNamaBarangCell);
            container.appendChild(inputQuantityCell);
            container.appendChild(buttonHapusCell);
            
            document.querySelector('#listBarang').appendChild(container);
            
            
            if(document.querySelectorAll(".barangTermutasi").length >= 0){
                document.querySelector("#empty-row").setAttribute("class","d-none");
            }
            
            $("#selectedKodeBarang").val(null).trigger("change");
            document.querySelector('#selectedQuantity').value = 0;


        }

    }


    $('.autocompletebarang').select2({
        placeholder: 'Select Barang',
        ajax: {
            url: '/barang/searchQuery',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.kodeBarang+'-'+item.namaBarang,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    function createRowNumber(){
        const d = document.createElement('div');
        d.innerText = document.querySelectorAll(".barangTermutasi").length + 1;
        return d;
    }

    function inserIntoCell(elements){
        const td = document.createElement('td');
        if(Array.isArray(elements)){
            elements.forEach(element => {
                td.appendChild(element);
            });

            return td;
        }

        td.appendChild(elements);
        return td;

    }

    function getSelectedBarangValue(){
        return document.querySelector('#selectedKodeBarang').value;
    }

    function getSelectedBarangTextValue(){
        const sel = document.querySelector('#selectedKodeBarang');
        return sel.options[sel.selectedIndex].text
    }

    function getSelectedBarangQuantity(){
        return document.querySelector('#selectedQuantity').value;
    }

    function createSelectedPlaceholder(){
        const val = getSelectedBarangValue();
        const container = document.createElement('tr');
        container.classList.add("barangTermutasi");
        container.classList.add("form-group-"+val);

        return container;
    }

    
    function createInputKodeBarang(){
        const val = getSelectedBarangValue();
        const inputKodeBarang = document.createElement('input');
        Object.assign(inputKodeBarang,{
            type: 'hidden',
            readonly:'true',
            value: val,
            name:'idBarang[]'
        });

        return inputKodeBarang;
    }

    function createTextNamaBarang(){
        const text = getSelectedBarangTextValue();
        const inputNamaBarang = document.createElement('div');
        inputNamaBarang.innerText = text;
        return inputNamaBarang;
    }

    function createInputNamaBarang(){
        const text = getSelectedBarangTextValue();
        const inputNamaBarang = document.createElement('input');
            
            Object.assign(inputNamaBarang,{
                type: 'hidden',
                value: text,
                name:'namaBarang[]'
            });

        return inputNamaBarang;
    }

    function createInputQuantity(){
        const qty = getSelectedBarangQuantity();
        const inputQuantity = document.createElement('input');
            
            Object.assign(inputQuantity,{
                type: 'text',
                value: qty,
                name:'quantity[]'
            });

        return inputQuantity;
    }

    function createRemoveSelectedPlaceholderButton(){
            const val = getSelectedBarangValue();
            const buttonHapus = document.createElement('button');
            buttonHapus.classList.add("btn");
            buttonHapus.classList.add("btn-danger");

            Object.assign(buttonHapus,{
                onclick: (e) => hapusBaris(e,val),
                innerText: '-',
            });

            return buttonHapus;
    }

    const hapusBaris = (e,val) => {
        e.preventDefault();
        
        const y = document.querySelector(".form-group-"+val).remove();

        if(document.querySelectorAll(".barangTermutasi").length == 0){
            document.querySelector("#empty-row").setAttribute("class","");
        }
    }

    

</script>

</html>