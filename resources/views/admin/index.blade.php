@include('template.header')
    
@include('template.navbar')
@include('komponen.pesan')
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('template.sidebar')
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="row">
              <div class="col-sm-12">
                <div class="home-tab">
                  <div class="d-sm-flex align-items-center justify-content-between border-bottom">
                    
                  </div>
                  <div class="tab-content tab-content-basic">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview">
                      <div class="row">
                        <div class="col-sm-12">
                          <div class="statistics-details d-flex align-items-center justify-content-between">
                            <div>
                              <p class="statistics-title">Total Alumni</p>
                              <h3 class="rate-percentage">{{ $totalAlumni }}</h3>
                            </div>
                            @foreach($status as $status)
                                <div>
                                  <p class="statistics-title">Total {{ $status->status }}</p>
                                  <h3 class="rate-percentage">{{ $status->alumni_count }}</h3>
                                </div>
                            @endforeach
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-8 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-12 col-lg-4 col-lg-12 grid-margin stretch-card">
                              <div class="card card-rounded">
                                <div class="card-body">
                                  <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                      <h4 class="card-title card-title-dash">Performance Line Chart</h4>
                                      <h5 class="card-subtitle card-subtitle-dash">Lorem Ipsum is simply dummy text of the printing</h5>
                                    </div>
                                    <div id="performanceLine-legend"></div>
                                  </div>
                                  <div class="chartjs-wrapper mt-4">
                                    <canvas id="performanceLine" width=""></canvas>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-4 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                              <div class="card card-rounded">
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-lg-12">
                                      <div class="d-flex justify-content-between align-items-center">
                                        <h6 class=" card-title-dash"><strong>Statistik Alumni Berdasarkan Status</strong></h6>
                                      </div>
                                      <div id="doughnutChart-legend" class="mb-2 mt-3 text-center" style="margin-left: -40px"></div>
                                      <div>
                                        <canvas class="my-auto" id="doughnutChart"></canvas>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-lg-8 d-flex flex-column">
                          <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                              <div class="card card-rounded">
                                <div class="card-body">
                                  <div class="d-sm-flex justify-content-between align-items-start">
                                    <div>
                                      <h4 class="card-title card-title-dash">Market Overview</h4>
                                      <p class="card-subtitle card-subtitle-dash">Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
                                    </div>
                                    <div>
                                      <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle toggle-dark btn-lg mb-0 me-0" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> This month </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                          <h6 class="dropdown-header">Settings</h6>
                                          <a class="dropdown-item" href="#">Action</a>
                                          <a class="dropdown-item" href="#">Another action</a>
                                          <a class="dropdown-item" href="#">Something else here</a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item" href="#">Separated link</a>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="d-sm-flex align-items-center mt-1 justify-content-between">
                                    <div class="d-sm-flex align-items-center mt-4 justify-content-between">
                                      <h2 class="me-2 fw-bold">$36,2531.00</h2>
                                      <h4 class="me-2">USD</h4>
                                      <h4 class="text-success">(+1.37%)</h4>
                                    </div>
                                    <div class="me-3">
                                      <div id="marketingOverview-legend"></div>
                                    </div>
                                  </div>
                                  <div class="chartjs-bar-wrapper mt-3">
                                    <canvas id="marketingOverview"></canvas>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row flex-grow">
                            <div class="col-12 grid-margin stretch-card">
                              <div class="card card-rounded table-darkBGImg">
                                <div class="card-body">
                                  <div class="col-sm-8">
                                    <h3 class="text-white upgrade-info mb-0"> Enhance your <span class="fw-bold">Campaign</span> for better outreach </h3>
                                    <a href="#" class="btn btn-info upgrade-btn">Upgrade Account!</a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          @include('template.copyright')
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
@include('template.footer')