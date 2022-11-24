@extends('layouts.main')

@section('content')
<div class="content-page killa">
    <!-- Start content -->
    <div class="content">
        <div class="container-fluid">
            <!-- Start transaction log Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <h4 class="page-title" style=" color: black !important; "></h4>
                </div>
            </div>

            @if(session()->has('status'))
                <div class="alert alert-{{ session()->get('status') }} fade in">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    {{ session()->get('message') }}
                </div>
            @endif


            <div class="row">
                <div class="col-12">
                    <div class="card-box table-responsive">
                        <h3 class="btn btn-inverse  btn-block waves-effect waves-light" style="background-color: #83c324 !important;">
                             RANK REPORTS
                        </h3>

                        <table id="datatable-buttons" class="table table-striped table-bordered" cellspacing="0" width="100%">

                            <div id="reportrange" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                                <i class="fa fa-calendar"></i>&nbsp;
                                <span></span> <i class="fa fa-caret-down"></i>
                            </div>

                            <thead>
                                <tr>
                                    <th>Top</th>
                                    <th>Distributor Name</th>
                                    <th>Total Sales</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

        </div> <!-- container -->

    </div> <!-- content -->

</div>

@endsection

    @section('script')
    <script src="{{ asset('assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/buttons.print.min.js') }}"></script>

    <!-- Key Tables -->
    <script src="{{ asset('assets/plugins/datatables/dataTables.keyTable.min.js') }}"></script>

    <!-- Responsive examples -->
    <script src="{{ asset('assets/plugins/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/responsive.bootstrap4.min.js') }}"></script>

    <!-- Selection table -->
    <script src="{{ asset('assets/plugins/datatables/dataTables.select.min.js') }}"></script>



    <script type="text/javascript">
        $(document).ready(function() {


            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            let startDate = moment('2019-01-02');
            let endDate = moment();
            let isDate = false;
            const report = $('#reportrange').data('report');
            const reportId = $('#reportrange').data('id');

            let table = $('#datatable-buttons').DataTable({
                "ajax":{
                        url: "/reports/rank",
                        dataType: "json",
                        type: "POST",
                        data: function(data){
                            data._token =  CSRF_TOKEN;
                            data._method = 'post'
                            data.startDate = startDate.format('YYYY-MM-DD');
                            data.endDate = endDate.format('YYYY-MM-DD');
                            data.isDate = isDate;
                            data.type = report;
                            data.extra_id = reportId
                            return data;
                        }
                    },
                "processing":true,
                "serverSide":true,
                "columns": [
                    { "data": "Top" },
                    { "data": "Distributor Name" },
                    { "data": "Total Sales" }
                ],
                "initComplete": function( settings, json ) {
                    table.buttons().container()
                    .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');
                }
            } );
            $.fn.dataTable.ext.buttons.alert = {
                className: 'buttons-alert',

            };
            // Key Tables

            $('#key-table').DataTable({
                keys: true
            });

            // Responsive Datatable
            $('#responsive-datatable').DataTable();

            // Multi Selection Datatable
            $('#selection-datatable').DataTable({
                select: {
                    style: 'multi'
                }
            });




            $('#reportrange').daterangepicker({
                startDate: startDate,
                endDate: endDate,
                ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            }, function(start, end){
                startDate = start;
                endDate = end;
                isDate = true;
                $('#reportrange span').html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));
                table.draw()
            });

            $('#reportrange span').html(startDate.format('MMMM D, YYYY') + ' - ' + endDate.format('MMMM D, YYYY'));



        } );
    </script>


@endsection
