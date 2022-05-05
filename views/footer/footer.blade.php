 <!--begin::Footer-->
 <div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
     <!--begin::Container-->
     <div
         class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
         <!--begin::Copyright-->
         <div class="text-dark order-2 order-md-1">
             <span class="text-muted fw-bold me-1">2021 ©</span>
             <a href="#" class="text-gray-800 text-hover-primary">HD | Resources
                 LTD | Ayebare Timothy (Fullstack) | Edsell Muhindo
                 (Micro-services)</a>
         </div>
         <!--end::Copyright-->

     </div>
     <!--end::Container-->
 </div>

 <div class="d-none">
     <input type="text" id="GetVirtualHost" class="d-none"
         value="{{ session()->get('VirtualHost') }}">
     <input type="text" class="TotalSumHere2" class="d-none" value="0">

     <input type="text" class="DEDUCTIBLE_BALANCE" class="d-none"
         value="">

 </div>
 <!--end::Footer-->


 <div class="modal fade" id="UpdateAccountDetails">
     <div class="modal-dialog modal-dialog-scrollable modal-fullscreen">
         <div class="modal-content">
             <div class="modal-header bg-gray">
                 <h5 class="modal-title">Hello {{ Auth::user()->name }},
                     Let's Update Your Account Details</h5>



                 <!--begin::Close-->
                 <div class="btn btn-icon btn-sm btn-active-light-primary ms-2"
                     data-bs-dismiss="modal" aria-label="Close">
                     <i class="fas fa-2x fa-times" aria-hidden="true"></i>
                 </div>
                 <!--end::Close-->
             </div>

             <div class="modal-body ">

                 <form action="{{ route('UpdateAccount') }}"
                     class="row" method="POST"> @csrf
                     <div class="row">

                         <div class="mt-3  mb-3 col-md-3  ">
                             <label id="label" for=""
                                 class=" required form-label">Name</label>
                             <input type="text" name="name"
                                 class="form-control"
                                 value="{{ Auth::user()->name }}">
                         </div>

                         <div class="mt-3  mb-3 col-md-3  ">
                             <label id="label" for=""
                                 class=" required form-label">Username</label>
                             <input type="text" name="email"
                                 class="form-control"
                                 value="{{ Auth::user()->email }}">
                         </div>


                         <input type="hidden" name="id"
                             value="{{ Auth::user()->id }}">

                         <div class="mt-3  mb-3 col-md-3  ">
                             <label id="label" for=""
                                 class=" required form-label">Password</label>
                             <input type="password" name="password"
                                 class="form-control">

                         </div>

                         <div class="mt-3  mb-3 col-md-3  ">
                             <label id="label" for=""
                                 class=" required form-label">Confirm
                                 Password</label>
                             <input type="password" name="password_confirmation"
                                 class="form-control">

                         </div>




                     </div>
             </div>

             <div class="modal-footer">
                 <button type="button" class="btn btn-info"
                     data-bs-dismiss="modal">Close</button>

                 <button type="submit" class="btn btn-dark">Save
                     Changes</button>

                 </form>
             </div>

         </div>
     </div>
 </div>
