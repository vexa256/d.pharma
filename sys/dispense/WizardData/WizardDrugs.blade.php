  <!--begin::Step 1-->


  <div class="flex-column " data-kt-stepper-element="content">
      @include('dispense.WizardData.WizardTotal')
      <!--begin::Input group-->
      <div class="row mb-10">
          <div class="card-body pt-3 bg-light table-responsive">
              {{ HeaderBtn($Toggle = 'New', $Class = 'btn-danger', $Label = 'Add Stock Item', $Icon = 'fa-plus') }}
              <table
                  class="table table-rounded table-bordered table-striped border gy-3 gs-3">
                  <thead>
                      <tr class="fw-bold  text-gray-800 border-bottom border-gray-200">
                          <th>Patient</th>
                          <th>Phone</th>
                          {{-- <th>Email</th> --}}
                          <th>Item Name</th>
                          <th>Generic Name</th>
                          <th>Units </th>
                          <th>Unit Price </th>
                          <th>Qty </th>
                          <th>Sub Total</th>
                          <th class="bg-danger fw-bolder text-light"> Remove Item
                          </th>



                      </tr>
                  </thead>
                  <tbody class="DisplayCartItemsHere">







                  </tbody>
              </table>
          </div>
      </div>
      <!--end::Input group-->


  </div>
  <!--begin::Step 1-->
