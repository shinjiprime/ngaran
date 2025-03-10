<?php
@include('layout.header')
@include('layout.navigation')
?><?php 

  //              $query = 'SELECT ID, t.TYPE
    //                      FROM users u
      //                    JOIN type t ON t.TYPE_ID=u.TYPE_ID WHERE ID = '.$_SESSION['MEMBER_ID'].'';
        //        $result = mysqli_query($db, $query) or die (mysqli_error($db));
      //
        //        while ($row = mysqli_fetch_assoc($result)) {
          //                $Aa = $row['TYPE'];
            //       
//if ($Aa=='User'){
  //         
    //         ?>    <script type="text/javascript">
      //                //then it will be redirected
        //              alert("Restricted Page! You will be redirected to POS");
          //            window.location = "pos.php";
            //      </script>
             <?php   //}
                         
           
//}   
            ?>
          <div class="row show-grid">
            <!-- Customer ROW -->
            <div class="col-md-3">
            <!-- Customer record -->
            <div class="col-md-12 mb-3">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Customers</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800">
                        <?php 
                        $query = "SELECT COUNT(*) FROM customer";
                        $result = mysqli_query($db, $query) or die(mysqli_error($db));
                        while ($row = mysqli_fetch_array($result)) {
                            echo "$row[0]";
                          }
                        ?> Record(s)
                      </div>
                    </div>
                      <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                      </div>
                  </div>
                </div>
              </div>
            </div>

            

            <div class="col-md-12 mb-3">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">

                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Employees</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php 
                          $query = "SELECT COUNT(*) FROM employee";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "$row[0]";
                            }
                          ?> Record(s)
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <!-- User record -->
            <div class="col-md-12 mb-3">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Registered Account</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800">
                        <?php 
                        $query = "SELECT COUNT(*) FROM users WHERE TYPE_ID=2";
                        $result = mysqli_query($db, $query) or die(mysqli_error($db));
                        while ($row = mysqli_fetch_array($result)) {
                            echo "$row[0]";
                          }
                        ?> Record(s)
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-user fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="col-md-12 mb-3">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">

                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Product Suppliers</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php 
                          $query = "SELECT count(*) FROM item_supplier";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "$row[0]";
                            }
                          ?> Record(s)
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <i class="fas fa-dolly-flatbed fa-2x text-gray-300"></i>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12 mb-3">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">

                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pet Suppliers</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php 
                          $query = "SELECT count(*) FROM pet_supplier";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "$row[0]";
                            }
                          ?> Record(s)
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <i class="fas fa-dolly-flatbed fa-2x text-gray-300"></i>
                    </div>

                  </div>
                </div>
              </div>
            </div>



          </div>
            <!-- Employee ROW -->
          <div class="col-md-3">
            <!-- Employee record -->
            <div class="col-md-12 mb-3">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Adoption</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800">
                        <?php 
                        $query = "SELECT COUNT(*) FROM adoption";
                        $result = mysqli_query($db, $query) or die(mysqli_error($db));
                        while ($row = mysqli_fetch_array($result)) {
                            echo "$row[0]";
                          }
                        ?> Record(s)
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- User record -->
            <div class="col-md-12 mb-3">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pets</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800">
                        <?php 
                        $query = "SELECT COUNT(*) FROM pet";
                        $result = mysqli_query($db, $query) or die(mysqli_error($db));
                        while ($row = mysqli_fetch_array($result)) {
                            echo "$row[0]";
                          }
                        ?> Record(s)
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-cat fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="col-md-12 mb-3">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">

                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pets Revenue</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php 
                          $query = "SELECT SUM(pet_amount) FROM pet,adoption WHERE pet.pet_id=adoption.pet_id";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "$row[0]";
                            }
                          ?> Php
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            
            <div class="col-md-12 mb-3">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">

                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pet Breeds</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php 
                          $query = "SELECT count(*) FROM breed";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "$row[0]";
                            }
                          ?> Record(s)
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <i class="fas fa-dog fa-2x text-gray-300"></i>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-12 mb-3">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">

                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Pet Types</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php 
                          $query = "SELECT count(*) FROM pet_type";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "$row[0]";
                            }
                          ?> Record(s)
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>

                  </div>
                </div>
              </div>
            </div>




          </div>
          <!-- PRODUCTS ROW -->
          <div class="col-md-3">
            <!-- Product record -->
            <div class="col-md-12 mb-3">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">

                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Purchases</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php 
                          $query = "SELECT COUNT(*) FROM purchase";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "$row[0]";
                            }
                          ?> Record(s)
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12 mb-3">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">

                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Product</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php 
                          $query = "SELECT COUNT(*) FROM item";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "$row[0]";
                            }
                          ?> Record(s)
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <i class="fas fa-box fa-2x text-gray-300"></i>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-12 mb-3">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">

                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Product Revenue</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php 
                          $query = "SELECT SUM(item_price) FROM item,purchase WHERE item.item_id=purchase.item_id";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "$row[0]";
                            }
                          ?> Php
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                    </div>

                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-12 mb-3">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">

                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Product Stocks</div>
                      <div class="row no-gutters align-items-center">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-3 font-weight-bold text-gray-800">
                          <?php 
                          $query = "SELECT sum(item_stock) FROM item";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "$row[0]";
                            }
                          ?> Record(s)
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-auto">
                      <i class="fas fa-boxes fa-2x text-gray-300"></i>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <!-- Supplier record -->
            <div class="col-md-12 mb-3">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-0">
                      <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Item Categories</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800">
                        <?php 
                        $query = "SELECT COUNT(*) FROM item_category";
                        $result = mysqli_query($db, $query) or die(mysqli_error($db));
                        while ($row = mysqli_fetch_array($result)) {
                            echo "$row[0]";
                          }
                        ?> Record(s)
                      </div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
           
            

            </div>
            
          <!-- RECENT PRODUCTS -->
                <div class="col-lg-3">
                    <div class="card shadow h-100">
                      <div class="card-body">
                        <div class="row no-gutters align-items-center">

                          <div class="col-auto">
                            <i class="fa fa-th-list fa-fw"></i> 
                          </div>

                        <div class="panel-heading"> Recent Products
                        </div>
                        <div class="row no-gutters align-items-center mt-1">
                        <div class="col-auto">
                          <div class="h6 mb-0 mr-0 text-gray-800">
                        <!-- /.panel-heading -->
                        
                        <div class="panel-body">
                            <div class="list-group">
                              <?php 
                                $query = "SELECT item_id, item_brand FROM item order by item_id DESC LIMIT 10";
                                $result = mysqli_query($db, $query) or die(mysqli_error($db));
                                while ($row = mysqli_fetch_array($result)) {

                                    echo "<a href='#' class='list-group-item text-gray-800'>
                                          <i class='fa fa-tasks fa-fw'></i>  $row[1]
                                          </a>";
                                  }
                              ?>
                            </div>
                            <!-- /.list-group -->
                            <a href="item.php" class="btn btn-default btn-block">View All Products</a>
                        </div>
                        <!-- /.panel-body -->
                    </div></div></div></div></div></div>
          <!-- 
          <div class="col-md-3">
           <div class="col-md-12 mb-2">
              <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1"><i class="fas fa-list text-danger">&nbsp;&nbsp;&nbsp;</i>Recent Products</div>
                      <div class="h6 mb-0 font-weight-bold text-gray-800">
                        <?php 
                          $query = "SELECT NAME FROM product order by PRODUCT_ID DESC LIMIT 10";
                          $result = mysqli_query($db, $query) or die(mysqli_error($db));
                          while ($row = mysqli_fetch_array($result)) {
                              echo "<ul style='list-style-position: outside'>";
                              echo "<li>$row[0]</li>";
                              echo "</ul>";
                            }
                          ?>
                      </div>
                    </div>
                    <div class="col-auto">
                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </div> -->
            

          </div>

<?php
include'../includes/footer.php';
?>