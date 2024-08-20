<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partnership Page</title>
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
    <main class="partnership">
        <div class="img">
            <img src="./../images/SponsorWebBanner.png" width="100%">
        </div>
        <section class="contact-us row justify-content-center">
            <p style="font-size: 1.28rem; background-color: rgba(244, 190, 90, 0.368); font-weight: bold; ">Your support is essential for the defense of children's rights. If you wish to become a volunteer, make a donation, or participate in our events, contact us now!</p>
            <form action="#" method="post" class="was-validated text-light col-sm-5 m-2 shadows-lg">
                <fieldset><legend class="fw-bold">Send us your Message filling out the form below</legend>
                        <label for="email" class="fw-bold">Email</label><br>
                        <input type="email" id="email" name="email" class="form-control" placeholder="email" required>
                        <div class="invalid-feedback">Please fill in this field!</div>
                        <label for="subjet" class="fw-bold">Subjet</label><br>
                        <input type="text" id="subjet" name="subjet" class="form-control" placeholder="Subjet" required>
                        <div class="invalid-feedback">Please fill in this field!</div>
                        <label for="message" class="fw-bold">Message: </label>
                        <textarea name="message" cols="30" rows="5" placeholder="Write your message here!" id="message" class="form-control"></textarea>
                        <div class="form-check form-switch container">
                            <a href="#">Terms of Service and Privacy Policy</a><br>
                            <input type="checkbox" class="form-check-input" name="check" id="check">
                            <label for="check">Do you agree to our conditions of use?</label>
                        </div>
                        <input type="submit" value="Send Your Message" name="ok" id="ok" class="btn-primary text-light fw-bold container">
                </fieldset>
            </form>
        </section>
        <section class="section-programs">
            <div class="p-3">
                <h1 class="text-light text-center">PROGRAMS OF THE ORGANIZATION</h1>
                <p>Initiative for Child Protection and Empowerment (ICPE), conducts its developmental activities in the following key areas:
                    <br>✔ Children Education and Development
                    <br>✔ Financial Aid for Children Education, Protection and Empowerment.
                    <br>✔ Children empowerment and Child Right Advocacy
                    <br>✔ Children Health and Social Counseling Programs
                    <br>✔ Promotion of Good Leadership, governance, Rule of Law and Peace Building Programs.
                    <br>✔ Promote Second Chance Education for teenage children.
                </p>
            </div>
            <div class="p-3">
                <h1 class="text-light text-center">STRATEGIES AND ENGAGEMENT</h1>
                <p>Our strategies and engagement include:
                    <br>✔ To influence public policy in the best interest of Children in Liberia.
                    <br>✔ Partner with the Ministry of Sports, Education and social protection in promoting Children reform programs in Liberia.
                    <br>✔ Children Empowerment and Child Rights Advocacies
                    <br>✔ To render education services and social assistance.
                    <br>✔ Promotion of Good Leadership, Governance, Rule of Law and Peace Building Programs.
                    <br>✔ Scholarship for all Child/Children.
                    <br>✔ Conduct live community interactive programs through community dialogue involving students, young People on affecting Children in general.
                </p>
            </div>
        </section>
        <section class="mb-3 mt-3">
        <div class="text-center text-dark" style="width:35rem; border: 3px dotted rgb(0, 174, 255); background-color: rgba(244, 190, 90, 0.368);">
            <h2>Do you have any question or do you want to know more about our Mission?</h2>
            <p>Contact us through :</p>
            <ul class="nav flex-column">
                <li>Phone <img src="./../images/whatsapp.png" width="20px" alt="">: 
                    <a class=" text-decoration-none fw-bold" href="https://wa.me/231775609045">+231775609045</a>/
                    <a class="text-decoration-none  fw-bold" href="https://wa.me/212632026205">+212632026205</a>
                </li>
                <li>Email <img src="./../images/logo gmail.png" width="20px" alt="">: 
                    <a class=" text-decoration-none  fw-bold" href="mailto:karnleyandrew98@gmail.com">karnleyandrew98@gmail.com</a>/
                    <a class="text-decoration-none  fw-bold" href="mailto:icpe2019@gmail.com">icpe2019@gmail.com</a>
                </li>   
                <li>Adress <img src="./../images/logo adress.jpeg" width="20px" alt="">: <span>St. Paul Bridge Bushrod Island, Monrovia, Liberia</span></li>
            </ul>
        </div>
    </section>
        <section class="">
            <div class="row mb-3">
                <div class="col alert-info">
                    <div class="text-center fw-bold">
                        <h1>Do you need immediate help?</h1>
                        <p>If you witness or are a victim of violence against children, <br>Contact our 24/7 helpline immediately: <span class="text-light bg-info text-decoration-none d-inline-block fw-bold">+231775609045, +212632026205, karnleyandrew98@gmail.com</span></p>
                    </div>
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