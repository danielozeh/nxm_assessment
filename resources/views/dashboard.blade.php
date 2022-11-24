@extends('layouts.main')

@section('content')
<div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container-fluid">

                        @if(session()->has('status'))
                            <div class="alert alert-{{ session()->get('status') }}">
                                {{ session()->get('message') }}
                            </div>
                        @endif
                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12"> 

                                <h4 class="page-title">Dashboard</h4> 
                            </div>
                        </div> 
                         

                        <div class="row">
                            
                        <div class="mt-20 col-sm-12">  
                                <h4 class="  header-title">TODAY <small>-- {!! Date('d M, Y') !!}</small></h4>  
                            </div> 
                            <div class="col-sm-12">
                                <div class="card-box widget-inline">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-4 col-xl-4">
                                            <div class="widget-inline-box text-center">
                                                <h3><i style=" color: #008751 !important;" class="text-primary md md-store-mall-directory"></i> <b data-plugin="counterup">{{ $order_count }}</b></h3>
                                                <h4 class="text-muted font-16">Total Orders Count</h4>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 col-xl-4">
                                            <div class="widget-inline-box text-center">
                                                <h3><i style ="color: #f4d142 !important; " class="text-custom md md-publish"></i> <b data-plugin="counterup">{{ $product_count }}</b></h3>
                                                <h4 class="text-muted font-16">Total Product Count</h4>
                                            </div>
                                        </div>

                                        <div class="col-md-6 col-lg-4 col-xl-4">
                                            <div class="widget-inline-box text-center">
                                                <h3><i style ="color: #bc0111 !important; " class="text-pink md md-album"></i> <b data-plugin="counterup">{{ number_format($product_sum, 2) }}</b></h3>
                                                <h4 class="text-muted font-16">Total Product Amount</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                          
                        <div class="row">
                            
                        </div>




                        </div>
                        <!-- end row -->
                         
                         

                    </div> <!-- container -->

                </div> <!-- content --> 
                
                 

@endsection
@section('script') 
 
<script type="text/javascript"> 


</script>
@endsection