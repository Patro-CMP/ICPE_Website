<?php include './../includes/connect.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ICPE Archives and Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./../others_pages/style.css">
</head>
<body >
<!-- /// ////////////////////------HEADER------/////////////// //////////////////// -->
    <header>
        <?php include "./../includes/header.php"; ?>
    </header>

<!-- /// ////////////////////------MAIN------/////////////// //////////////////// -->
<main class="mt-5 m-0">  <hr>
<section class="blog mt-5">
        <div class="inner">
            <span id="initiative">INITIATIVE FOR CHILD</span>&nbsp;
            <span id="protection">PROTECTION AND EMPOWERMENT</span>
        </div>
<!-- ________________Display Blog From Database___________________________-->
        <section>
          <div class="alert-info">
            <h2 class="text-center text-primary">Welcome to our blog</h2>
            <h4 class="text-center text-primary">Nurturing Future Leaders Through Protection and Empowerment.</h4>
          </div>
          <?php
            // Requête pour récupérer les posts classés par date, du plus récent au plus ancien
            $sql = "SELECT * FROM posts ORDER BY created_at DESC, title ASC";
            $result = $connex->query($sql);

            // Afficher les articles
            echo '<div class="row d-sm-flex justify-content-center">';

            while ($row = $result->fetch()) {
                // Si created_at est NULL, utilise la date actuelle
                $formatted_date = is_null($row["created_at"]) ? date("Y-m-d") : date("Y-m-d", strtotime($row["created_at"]));
                
                echo '<div class="col-sm-3 mb-1"  style="height: 100%;">';
                echo '<div class="card">';
                echo '<h2 class="card-header alert-info">'.htmlspecialchars($row['title']).'</h2>';
                echo '<div class="card-body">';

                // Vérifier le type de média et l'afficher
                $media_path = './../models_database/uploads/'.htmlspecialchars($row['media']);
                if (!empty($row['media'])) {
                    if (preg_match('/\.(jpeg|jpg|png|gif)$/i', $row['media'])) {
                        echo '<img src="'.$media_path.'" class="card-img" alt="'.htmlspecialchars($row['title']).'">';
                    } elseif (preg_match('/\.(mp4|avi|mov|mkv)$/i', $row['media'])) {
                        echo '<video controls class="card-img-top">';
                        echo '<source src="'.$media_path.'" type="video/mp4">';
                        echo 'Your browser does not support videos.';
                        echo '</video>';
                    }
                }
                
                // Afficher le commentaire ou une valeur par défaut
                $comment = !empty($row['comment']) ? htmlspecialchars($row['comment']) : 'ICPE_post';
                echo '<blockquote class="card-text overflow-auto text-info" style="height: 100px;">'.$comment.'</blockquote>';
                
                echo '<p class="card-text"><small class="text-muted">'.$formatted_date.'</small></p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }

            echo '</div>';

          ?>

        </section>
<!-- ________________ARCHIVES__Donation to Orphans and Widows___________________________-->
        <section class="archives m-0 mb-3">
            <h1 class="text-center text-light mb-0">Donation to Orphans and Widows</h1>
            <div class="row m-0">
              <div class="col-sm-2 bg-warning"  style="z-index:2"></div>
              <div class="col-sm-4 bg-info m-0 text-center"  style="z-index:2">
                <img src="./../images/Widows Day6.jpg" class="d-block w-100 text-center mt-2 mb-2"  alt="">
              </div>
              <div class="col-sm m-0 bg-info text-center"  style="z-index:-1">
                <div id="carouselExampleCaptions" class="carousel slide mt-5 me-0" data-bs-ride="carousel"  style="z-index:1">
                  <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                  </div>
                  <div class="carousel-inner">
                    </div>
                    <div class="carousel-item active" data-bs-interval="500">
                      <img src="./../images/Widows Day_2.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the second slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/Donations5.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Some representative placeholder content for the third slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/Widows.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Forth slide label</h5>
                        <p>Some representative placeholder content for the forth slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/Child_.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Fifth slide label</h5>
                        <p>Some representative placeholder content for the fifth slide.</p>
                      </div>
                    </div>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
              </div>
              <div class="col-sm-2 bg-warning"  style="z-index:2"></div>
            </div>
      </div>
  </section>
<!-- ________________Social_WORKS ___________________________-->
        <section class="archives m-0 mb-5">
            <h1 class="text-center text-light mb-0">Social Works</h1>
            <div class="row m-0">
              <div class="col-sm-2 bg-warning"  style="z-index:2"></div>
              <div class="col-sm-4 bg-info m-0 text-center"  style="z-index:2">
                <img src="./../images/SocialWork.jpg" class="d-block w-100 text-center mt-2 mb-2"  alt="">
              </div>
              <div class="col-sm m-0 bg-info text-center"  style="z-index:-1">
                <div id="carouselExampleCaptions" class="carousel slide mt-5 me-0" data-bs-ride="carousel"  style="z-index:1">
                  <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                  </div>
                  <div class="carousel-inner">
                    </div>
                    <div class="carousel-item active" data-bs-interval="500">
                      <img src="./../images/SocialWork1.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the second slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/SocialWork2.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Some representative placeholder content for the third slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/SocialWorks.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Forth slide label</h5>
                        <p>Some representative placeholder content for the forth slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/SocialWorks.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Fifth slide label</h5>
                        <p>Some representative placeholder content for the fifth slide.</p>
                      </div>
                    </div>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
              </div>
              <div class="col-sm-2 bg-warning"  style="z-index:2"></div>
            </div>
          </div>
        </section>
<!-- ________________Students Sensitization___________________________-->
        <section class="archives m-0 mb-5">
            <h1 class="text-center text-light mb-0">Students Sensitization</h1>
            <div class="row m-0">
              <div class="col-sm-2 bg-warning"  style="z-index:2"></div>
              <div class="col-sm-4 bg-info m-0 text-center"  style="z-index:2">
                <img src="./../images/Sentisation.jpg" class="d-block w-100 text-center mt-2 mb-2"  alt="">
              </div>
              <div class="col-sm m-0 bg-info text-center"  style="z-index:-1">
                <div id="carouselExampleCaptions" class="carousel slide mt-5 me-0" data-bs-ride="carousel"  style="z-index:1">
                  <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                  </div>
                  <div class="carousel-inner">
                    </div>
                    <div class="carousel-item active" data-bs-interval="500">
                      <img src="./../images/Sensitisation School1.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the second slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/Entertainment.3jpg.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Some representative placeholder content for the third slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/Sensitisation School.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Forth slide label</h5>
                        <p>Some representative placeholder content for the forth slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/SCHOOL4.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Fifth slide label</h5>
                        <p>Some representative placeholder content for the fifth slide.</p>
                      </div>
                    </div>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
              </div>
              <div class="col-sm-2 bg-warning"  style="z-index:2"></div>
            </div>
          </div>
          <!--
              <div class="col-sm-3">
                <img src="./images/Sensitisation2.jpg" class="d-block w-100 mt-2  mb-2" alt="">
              </div>
              <div class="col-sm-3">
                <img src="./images/Sensitisation3.jpg" class="d-block w-100 mt-2  mb-2" alt="">
              </div>
              <div class="col-sm-3">
                <img src="" class="d-block w-100 mt-2  mb-2" alt="">
              </div>
              <div class="col-sm-3">
                <img src="./images/Entertainment2.jpg" class="d-block w-100 mt-2  mb-2" alt="">
              </div>
            </div> -->
        </section>
<!-- ________________Celebration International Widows Day___________________________-->
        <section class="archives m-0 mb-5">
            <h1 class="text-center text-light mb-0">Celebration International Widows Day</h1>
            <div class="row m-0">
              <div class="col-sm-2 bg-warning"  style="z-index:2"></div>
              <div class="col-sm-4 bg-info m-0 text-center"  style="z-index:2">
                <img src="./../images/Widows Days2.jpg" class="d-block w-100 text-center mt-2 mb-2"  alt="">
              </div>
              <div class="col-sm m-0 bg-info text-center"  style="z-index:-1">
                <div id="carouselExampleCaptions" class="carousel slide mt-5 me-0" data-bs-ride="carousel"  style="z-index:1">
                  <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                  </div>
                  <div class="carousel-inner">
                    </div>
                    <div class="carousel-item active" data-bs-interval="500">
                      <img src="./../images/Widowss.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the second slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/Widows Day7.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Some representative placeholder content for the third slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/Widows Day6.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Forth slide label</h5>
                        <p>Some representative placeholder content for the forth slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/Widows Day8.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Fifth slide label</h5>
                        <p>Some representative placeholder content for the fifth slide.</p>
                      </div>
                    </div>
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
              </div>
              <div class="col-sm-2 bg-warning"  style="z-index:2"></div>
            </div>
          </div>
        </section>
<!-- ________________Sensitization Against Covid-19 ___________________________-->
        <section class="archives m-0 mb-3">
            <h1 class="text-center text-light mb-0">Sensitization Against Covid-19</h1>
            <div class="row m-0">
              <div class="col-sm-2 bg-warning"  style="z-index:2"></div>
              <div class="col-sm-4 bg-info m-0 text-center"  style="z-index:2">
                <img src="./../images/Sensitisation__.jpg" class="d-block w-100 text-center mt-2 mb-2"  alt="">
              </div>
              <div class="col-sm m-0 bg-info text-center"  style="z-index:-1">
                <div id="carouselExampleCaptions" class="carousel slide mt-5 me-0" data-bs-ride="carousel"  style="z-index:1">
                  <div class="carousel-indicators">
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
                  </div>
                  <div class="carousel-inner">
                    </div>
                    <div class="carousel-item active" data-bs-interval="500">
                      <img src="./../images/Corona_Virus3.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Second slide label</h5>
                        <p>Some representative placeholder content for the second slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/Corona_Virus.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Third slide label</h5>
                        <p>Some representative placeholder content for the third slide.</p>
                      </div>
                    </div>
                    <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/Corona_Virus2.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Forth slide label</h5>
                        <p>Some representative placeholder content for the forth slide.</p>
                      </div>
                    </div>
                    <!-- <div class="carousel-item" data-bs-interval="2000">
                      <img src="./../images/Widows Day8.jpg" class="d-block w-100" height="350px" alt="...">
                      <div class="carousel-caption d-none d-md-block">
                        <h5>Fifth slide label</h5>
                        <p>Some representative placeholder content for the fifth slide.</p>
                      </div>
                    </div> -->
                  </div>
                  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                  </button>
                  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                  </button>
              </div>
              <div class="col-sm-2 bg-warning"  style="z-index:2"></div>
            </div>
          </div>
            <!-- <div class="row">
              <div class="col-sm-3">
                <img src="" class="d-block w-100 mt-2 mb-2"  alt="">
              </div>
              <div class="col-sm-3">
                <img src="" class="d-block w-100 mt-2 mb-2" alt="">
              </div>
              <div class="col-sm-3">
                <img src="" class="d-block w-100 mt-2 mb-2" alt="">
              </div>
              <div class="col-sm-3">
                <img src="" class="d-block w-100 mt-2 mb-2" alt="">
              </div>
            </div> -->
        </section>
    
        
<!-- _____________________IMAGES BOTTOM_________________________ -->
        <section class="wrapper images">
            <h2 class="text-center">Some quotes : </h2>
            <div class="row mt-3">
                <div class="card col-sm m-1 bg-info">
                    <h3 class="card-header">❌ Stop Child abuse!</h3>
                    <img  class="card-body" src="./../images/ICPE Awareness flyers 2.jpg" width="" alt="">
                </div>
                <div class="card col-sm m-1 bg-info">
                    <h3 class="card-header">Stop Child abuse!</h3>
                    <img class="card-body" src="./../images/MARCA 3.jpg" width="" alt="">
                </div>
                <div class="card col-sm m-1 bg-info">
                    <h3 class="card-header">❌ Violence against women</h3>
                    <img class="card-body" src="./../images/MARCA 2.jpg" width="" alt="">
                </div>
                <div class="card col-sm m-1 bg-info">
                    <h3 class="card-header">Children cannot save themsevelves</h3>
                    <img  class="card-body" src="./../images/images (3).jpg" width="" alt="">
                </div>
            </div>
        </section>

    </main> 
<!-- /// ////////////////////------FOOTER------/////////////// //////////////////// -->
    <footer>
        <?php include "./../includes/footer.php"; ?>
    </footer>
<!-- /// ////////////////////------SCRIPT JS------/////////////// //////////////////// -->
    <script src="./../others_pages/javascript.js"></script>
</body>
</html>