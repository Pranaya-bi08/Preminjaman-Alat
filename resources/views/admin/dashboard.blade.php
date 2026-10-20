@extends('layouts.master')
@section('content')
<div class="card-group">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <i class="mdi mdi-emoticon font-20 text-muted"></i>
                            <p class="font-16 m-b-5">New Clients</p>
                        </div>
                        <div class="ml-auto">
                            <h1 class="font-light text-right">23</h1>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 75%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <i class="mdi mdi-image font-20  text-muted"></i>
                            <p class="font-16 m-b-5">New Projects</p>
                        </div>
                        <div class="ml-auto">
                            <h1 class="font-light text-right">169</h1>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 60%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <i class="mdi mdi-currency-eur font-20 text-muted"></i>
                            <p class="font-16 m-b-5">New Invoices</p>
                        </div>
                        <div class="ml-auto">
                            <h1 class="font-light text-right">157</h1>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-purple" role="progressbar" style="width: 65%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Column -->
    <!-- Column -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex no-block align-items-center">
                        <div>
                            <i class="mdi mdi-poll font-20 text-muted"></i>
                            <p class="font-16 m-b-5">New Sales</p>
                        </div>
                        <div class="ml-auto">
                            <h1 class="font-light text-right">236</h1>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="progress">
                        <div class="progress-bar bg-danger" role="progressbar" style="width: 70%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contoh table -->
<!-- copy dari sini sampai penutup div class row untuk halaman index selanjutnya -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Contoh Table</h4>
                <h6 class="card-subtitle">Keterangan table</h6>
                <div class="table-responsive">
                    <table id="file_export" class="table table-striped table-bordered display">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Position</th>
                                <th>Office</th>
                                <th>Age</th>
                                <th>Start date</th>
                                <th>Salary</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Tiger Nixon</td>
                                <td>System Architect</td>
                                <td>Edinburgh</td>
                                <td>61</td>
                                <td>2011/04/25</td>
                                <td>$320,800</td>
                            </tr>
                            <tr>
                                <td>Garrett Winters</td>
                                <td>Accountant</td>
                                <td>Tokyo</td>
                                <td>63</td>
                                <td>2011/07/25</td>
                                <td>$170,750</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- contoh table end -->

<!-- contoh form input -->
<!-- copy dari sini sampai penutup div class row untuk halaman create atau edit selanjutnya -->
<div class="row">
    <div class="col-sm-12">
        <div class="card card-body">
            <h4 class="card-title">Contoh Forms</h4>
            <h5 class="card-subtitle">Keterangan </h5>
            <form class="form-horizontal m-t-30">
                <div class="form-group">
                    <label>Default Text <span class="help"> e.g. "George deo"</span></label>
                    <input type="text" name="example-name" class="form-control" placeholder="Your name here...">
                </div>
                <div class="form-group">
                    <label for="example-email">Email <span class="help"> e.g. "example@gmail.com"</span></label>
                    <input type="email" id="example-email" name="example-email" class="form-control" placeholder="Email">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="example-password" class="form-control" value="password">
                </div>
                <div class="form-group">
                    <label>Placeholder</label>
                    <input type="text" class="form-control" placeholder="placeholder">
                </div>
                <div class="form-group">
                    <label>Text area</label>
                    <textarea name="example-area" class="form-control" rows="5"></textarea>
                </div>
                <div class="form-group">
                    <label>Read only input</label>
                    <input class="form-control" type="text" placeholder="Readonly input here…" readonly>
                </div>
                <div class="form-group">
                    <fieldset disabled>
                        <label for="disabledTextInput">Disabled input</label>
                        <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input">
                    </fieldset>
                </div>
                <div class="form-group row p-t-20">
                    <div class="col-sm-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                            <label class="custom-control-label" for="customCheck1">Check this custom checkbox</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck2">
                            <label class="custom-control-label" for="customCheck2">Check this custom checkbox</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="customCheck3">
                            <label class="custom-control-label" for="customCheck3">Check this custom checkbox</label>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio1">Toggle this custom radio</label>
                        </div>
                        <div class="custom-control custom-radio">
                            <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input">
                            <label class="custom-control-label" for="customRadio2">Toggle this custom radio</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Input Select</label>
                    <select name="example-select" class="custom-select col-12" id="inlineFormCustomSelect">
                        <option selected>Choose...</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Default file upload</label>
                    <input type="file" name="example-file" class="form-control">
                </div>
                <div class="form-group">
                    <label>Custom File upload</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Upload</span>
                        </div>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="example-custom-file" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label>Helping text</label>
                    <input type="text" class="form-control" placeholder="Helping text">
                    <span class="help-block"><small>A block of help text that breaks onto a new line and may extend beyond one line.</small></span>
                </div>
                <a href="#" class="btn btn-warning">Kembali</a>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
