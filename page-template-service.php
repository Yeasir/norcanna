<?php
/* Template Name: Service Page */
get_header('service');
?>

    <!-- /.main start  -->
    <main class="main">

        <section id="map" class="map"></section>

        <section class="zip-code">
        <div class="container">
            <div class="row">
               <div class="col-12 m-auto">
                   <form action="">
                       <div class="input-group custom-input-group">
                           <div class="input-group-append mr-3">
                               <img src="images/zip_map.png" alt="">
                           </div>
                           <input type="text" class="form-control" placeholder="ZIP code" aria-label="ZIP code" aria-describedby="basic-addon2">
                       </div>
                   </form>
               </div>
            </div>
        </div>
        </section>

        <section class="service-map-content">
            <div class="container">
                <div class="row">
                    <div class="col-12 m-auto">
                        <h6>On-Demand Delivery Map</h6>
                        <p>Norcanna currently offers on-demand delivery of cannabis products within California. The map
                            above highlights areas that Norcanna is servicing. Enter an exact address to see if it is in
                            a delivery area.</p>
                        <p>
Please note, this map may not fully reflect school zones or other local restrictions where
                            Norcanna is prohibited from delivering. If you’re looking for information about Norcanna
Wellness, which ships CBD products across America, you can find a map of states serviced
                            here.</p>
                    </div>
                </div>

            </div>
        </section>


    </main>
    <!-- /.main start  -->



<!-- /.single-product start -->
<div class="modal service-message-model" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-lg-none d-md-none d-sm-block">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="rounded-circle mb-3">
                                <img src="images/location.png" alt="">
                            </div>

                            <div class="close-circle">
                                <h6>X</h6>
                            </div>



                            <h5 class="mb-4">We are sorry... </h5>
                            <h5>Delivery not available</h5>
                            <h6>  in your area!</h6>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- /.single-product end -->

<!-- /.single-product start -->
<div class="modal service-message-model-avaiable" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-lg-none d-md-none d-sm-block">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="container">
                    <div class="row">
                        <div class="col-12 text-center">
                            <div class="rounded-circle mb-4">
                                <img src="images/location.png" alt="">
                            </div>

                            <div class="close-circle green-bg">
                                <img src="images/check.png" alt="">
                            </div>

                            <h5 >Delivery  available</h5>
                            <h6>  in your area!</h6>
                            <div class="separator-yellow">

                                <ul class="list-inline text-right">
                                    <li class="list-inline-item">
                                        <h5> <div class="circle">
                                            <img src="images/watch.png" alt="">
                                        </div> ETA: <span>1hr </span> </h5>

                                    </li>
                                    <li class="list-inline-item">
                                        <h5> <div class="circle">
                                            <span>$</span>
                                        </div> Fee: <span>$5</span> </h5>

                                    </li>
                                </ul>

                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<!-- /.single-product end -->

<?php
get_footer();
