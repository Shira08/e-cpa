<?php
$bdd = new PDO ("mysql:host=localhost;dbname=e-cpa;charset=utf8",'root', '');
var_dump($_POST);
if(isset($_POST['submit']))
{
    
    $name= htmlspecialchars($_POST['name']);
    $surname= htmlspecialchars($_POST['surname']);
    $contact= htmlspecialchars($_POST['contact']);
    $city= htmlspecialchars($_POST['city']);
    
    if(!empty($name) && !empty($surname) && !empty($contact) && !empty($city))
    {
        if(strlen($name) < 255 && strlen($surname) < 255 && strlen($name) != 1 && strlen($surname) != 1)
        {
            if(strlen($contact) < 13 )
            {
                $uploadDirectory = "../Admin/Images/";
                $file_name = $_FILES['file']['name'];
                $file_extension =  strrchr($file_name,".");
                $extensions_autorisees = array('.jpg','.jpeg','.png');
                $validExtensions = array('jpg', 'jpeg', 'png', 'bmp');
                $file_size = $_FILES['file']['size'];
                $file_tmp_name = $_FILES['file']['tmp_name'];
                

                $file_dest = $uploadDirectory.$file_name;
                if(in_array($file_extension, $extensions_autorisees))
                {
                  if($file_size < 1024000)
                  {
                    if(move_uploaded_file($file_tmp_name,$file_dest))
                    {
                      $img_ref = rand();
                      $sqlValues = "";
                      foreach ($_FILES['files']['tmp_name'] as $imageKey => $imageValue) 
                          {

                            $image = $_FILES['files']['name'][$imageKey];
                            $imageSize = $_FILES['files']['size'][$imageKey];
                            $imageTmp = $_FILES['files']['tmp_name'][$imageKey];
                            $imageType = pathinfo($uploadDirectory.$image, PATHINFO_EXTENSION);
                    
                            // Get Image New Name
                            if ($image !== '') {
                    
                                $imageNewName = uniqid().".".$imageType;
                                if($imageSize > 1024000)
                                {
                                  $message .= "La taille de l'image ne doit pas être plus de 1Mo ..!";
                                }
                                else if (!empty($image) && !in_array($imageType, $validExtensions)) {
                                
                                  $message = "La photo de profil doit être une image  ..!";
                              }
                              else
                              {
                                $sqlValues .= "('".$imageNewName."', '".$img_ref."'),";
                    
                                $store = move_uploaded_file($imageTmp, $uploadDirectory.$imageNewName); 
                                $is_ok = "";
                              }
                            }
                            else{
                                $imageNewName = "";
                                $message .= "Image Required...!";
                            }
                            
                          }
                      
                       /* $insertUser = $bdd->prepare("INSERT INTO users (nam , surname , contact , pays , personal_img_url , galerie_img_ref) VALUES (?, ?, ?, ?, ?, ?)");
                        $insertUser->eecute(array($name,$surname,$contact,$city,$file_dest,$img_ref));*/
                        $req = $bdd ->  prepare('INSERT INTO users (nam , surname , contact , pays , personal_img_url , galerie_img_ref) VALUES(?,?,?,?,?,?)');
                        $req -> execute(array($name,$surname,$contact,$city,$file_dest,$img_ref));
                        var_dump($name,$surname,$contact,$city,$file_dest,$img_ref);
                      

                        //$bdd->exec($inserUsers);

                        /*var_dump($name,$surname,$contact,$city,$file_dest,$img_ref);
                        $insertImages = "INSERT INTO galerie_img (imag , galerie_img_ref) VALUES $sqlValues";
                        $bdd->query($insertImages);

                        $message_sucess = "Vos informations ont bien été enregistrées...Merci!";
                        $bdd->close();*/
                                          
                    }
                    else
                    {
                        $message = "Erreur d'envoie de l'image  ..!";
                    }
                  }
                  else
                  {
                    $message = "La taille de l'image ne doit pas être plus de 1Mo .....!";
                  }
                    
                }
                else
                {
                    $message = "La photo de profil doit être une image  ..!";
                }
            }
            else
            {
                $message = "Veuillez entrer un numéro valide suivant le format indiqué ..!";
            }

        }
        else
        {
            $message = "Le nom et le(s) prénom(s) doivent être moins de 255 caractères ..!";
        }
    }
    else
    {
       $message = "Veuillez remplir tout les champs ...!" ;
    }
}

 ?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">


    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <title>Contact Form #6</title>
  </head>
  <body>
  

  <div class="content">
    
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-10">
          

          <div class="row justify-content-between">
            <div class="col-md-6">
              <h3 class="heading mb-4 principal_title"><span>E-</span>CPA</h3>
              <h3 class="heading mb-4">Let's talk about everything!</h3>
              <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Voluptas debitis, fugit natus?</p>

              <p><img src="images/undraw-contact.svg" alt="Image" class="img-fluid"></p>


            </div>
            <div class="col-md-6">
              
              <form class="mb-5" action="" method="POST" id="contactForm"  enctype="multipart/form-data">
                <div class="row mb-2">
                  <div class="col-md-12 form-group">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Nom">
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-md-12 form-group">
                    <input type="text" class="form-control" name="surname" id="surname" placeholder="Prénom(s)">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12 mb-3">
                    <label for="exampleFormControlFile1">Insérez votre photo de profil</label>
                      <input type="file" name="file" placeholder="" class="form-control-file" id="exampleFormControlFile1">
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-md-12 form-group">
                    <input type="tel" class="form-control" name="contact" id="contact" placeholder="229 65005882">
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-md-12 form-group">
                    <select class="form-control form-control-sm" name="city">
                      <option>Sélectionnez votre pays</option>
                      <option value="Afrique_du_Sud">Afrique du Sud</option>
                      <option value="Albanie">Albanie</option>
                      <option value="Algerie">Algérie</option>
                      <option value="Allemagne">Allemagne</option>
                      <option value="Andorre">Andorre</option>
                      <option value="Angola">Angola</option>
                      <option value="Antigua-et-Barbuda">Antigua-et-Barbuda</option>
                      <option value="Arabie_saoudite">Arabie saoudite</option>
                      <option value="Argentine">Argentine</option>
                      <option value="Armenie">Arménie</option>
                      <option value="Australie">Australie</option>
                      <option value="Autriche">Autriche</option>
                      <option value="Azerbaidjan">Azerbaïdjan</option>
                      <option value="Bahamas">Bahamas</option>
                      <option value="Bahrein">Bahreïn</option>
                      <option value="Bangladesh">Bangladesh</option>
                      <option value="Barbade">Barbade</option>
                      <option value="Belau">Belau</option>
                      <option value="Belgique">Belgique</option>
                      <option value="Belize">Belize</option>
                      <option value="Benin">Bénin</option>
                      <option value="Bhoutan">Bhoutan</option>
                      <option value="Bielorussie">Biélorussie</option>
                      <option value="Birmanie">Birmanie</option>
                      <option value="Bolivie">Bolivie</option>
                      <option value="Bosnie-Herzégovine">Bosnie-Herzégovine</option>
                      <option value="Botswana">Botswana</option>
                      <option value="Bresil">Brésil</option>
                      <option value="Brunei">Brunei</option>
                      <option value="Bulgarie">Bulgarie</option>
                      <option value="Burkina">Burkina</option>
                      <option value="Burundi">Burundi</option>
                      <option value="Cambodge">Cambodge</option>
                      <option value="Cameroun">Cameroun</option>
                      <option value="Canada">Canada</option>
                      <option value="Cap-Vert">Cap-Vert</option>
                      <option value="Chili">Chili</option>
                      <option value="Chine">Chine</option>
                      <option value="Chypre">Chypre</option>
                      <option value="Colombie">Colombie</option>
                      <option value="Comores">Comores</option>
                      <option value="Congo">Congo</option>
                      <option value="Cook">Cook</option>
                      <option value="Coree_du_Nord">Corée du Nord</option>
                      <option value="Coree_du_Sud">Corée du Sud</option>
                      <option value="Costa_Rica">Costa Rica</option>
                      <option value="Cote_Ivoire">Côte d'Ivoire</option>
                      <option value="Croatie">Croatie</option>
                      <option value="Cuba">Cuba</option>
                      <option value="Danemark">Danemark</option>
                      <option value="Djibouti">Djibouti</option>
                      <option value="Dominique">Dominique</option>
                      <option value="Egypte">Égypte</option>
                      <option value="Emirats_arabes_unis">Émirats arabes unis</option>
                      <option value="Equateur">Équateur</option>
                      <option value="Erythree">Érythrée</option>
                      <option value="Espagne">Espagne</option>
                      <option value="Estonie">Estonie</option>
                      <option value="Etats-Unis">États-Unis</option>
                      <option value="Ethiopie">Éthiopie</option>
                      <option value="Fidji">Fidji</option>
                      <option value="Finlande">Finlande</option>
                      <option value="France">France</option>
                      <option value="Gabon">Gabon</option>
                      <option value="Gambie">Gambie</option>
                      <option value="Georgie">Géorgie</option>
                      <option value="Ghana">Ghana</option>
                      <option value="Grèce">Grèce</option>
                      <option value="Grenade">Grenade</option>
                      <option value="Guatemala">Guatemala</option>
                      <option value="Guinee">Guinée</option>
                      <option value="Guinee-Bissao">Guinée-Bissao</option>
                      <option value="Guinee_equatoriale">Guinée équatoriale</option>
                      <option value="Guyana">Guyana</option>
                      <option value="Haiti">Haïti</option>
                      <option value="Honduras">Honduras</option>
                      <option value="Hongrie">Hongrie</option>
                      <option value="Inde">Inde</option>
                      <option value="Indonesie">Indonésie</option>
                      <option value="Iran">Iran</option>
                      <option value="Iraq">Iraq</option>
                      <option value="Irlande">Irlande</option>
                      <option value="Islande">Islande</option>
                      <option value="Israël">Israël</option>
                      <option value="Italie">Italie</option>
                      <option value="Jamaique">Jamaïque</option>
                      <option value="Japon">Japon</option>
                      <option value="Jordanie">Jordanie</option>
                      <option value="Kazakhstan">Kazakhstan</option>
                      <option value="Kenya">Kenya</option>
                      <option value="Kirghizistan">Kirghizistan</option>
                      <option value="Kiribati">Kiribati</option>
                      <option value="Koweit">Koweït</option>
                      <option value="Laos">Laos</option>
                      <option value="Lesotho">Lesotho</option>
                      <option value="Lettonie">Lettonie</option>
                      <option value="Liban">Liban</option>
                      <option value="Liberia">Liberia</option>
                      <option value="Libye">Libye</option>
                      <option value="Liechtenstein">Liechtenstein</option>
                      <option value="Lituanie">Lituanie</option>
                      <option value="Luxembourg">Luxembourg</option>
                      <option value="Macedoine">Macédoine</option>
                      <option value="Madagascar">Madagascar</option>
                      <option value="Malaisie">Malaisie</option>
                      <option value="Malawi">Malawi</option>
                      <option value="Maldives">Maldives</option>
                      <option value="Mali">Mali</option>
                      <option value="Malte">Malte</option>
                      <option value="Maroc">Maroc</option>
                      <option value="Marshall">Marshall</option>
                      <option value="Maurice">Maurice</option>
                      <option value="Mauritanie">Mauritanie</option>
                      <option value="Mexique">Mexique</option>
                      <option value="Micronesie">Micronésie</option>
                      <option value="Moldavie">Moldavie</option>
                      <option value="Monaco">Monaco</option>
                      <option value="Mongolie">Mongolie</option>
                      <option value="Mozambique">Mozambique</option>
                      <option value="Namibie">Namibie</option>
                      <option value="Nauru">Nauru</option>
                      <option value="Nepal">Népal</option>
                      <option value="Nicaragua">Nicaragua</option>
                      <option value="Niger">Niger</option>
                      <option value="Nigeria">Nigeria</option>
                      <option value="Niue">Niue</option>
                      <option value="Norvège">Norvège</option>
                      <option value="Nouvelle-Zelande">Nouvelle-Zélande</option>
                      <option value="Oman">Oman</option>
                      <option value="Ouganda">Ouganda</option>
                      <option value="Ouzbekistan">Ouzbékistan</option>
                      <option value="Pakistan">Pakistan</option>
                      <option value="Panama">Panama</option>
                      <option value="Papouasie-Nouvelle_Guinee">Papouasie - Nouvelle Guinée</option>
                      <option value="Paraguay">Paraguay</option>
                      <option value="Pays-Bas">Pays-Bas</option>
                      <option value="Perou">Pérou</option>
                      <option value="Philippines">Philippines</option>
                      <option value="Pologne">Pologne</option>
                      <option value="Portugal">Portugal</option>
                      <option value="Qatar">Qatar</option>
                      <option value="Republique_centrafricaine">République centrafricaine</option>
                      <option value="Republique_dominicaine">République dominicaine</option>
                      <option value="Republique_tcheque">République tchèque</option>
                      <option value="Roumanie">Roumanie</option>
                      <option value="Royaume-Uni">Royaume-Uni</option>
                      <option value="Russie">Russie</option>
                      <option value="Rwanda">Rwanda</option>
                      <option value="Saint-Christophe-et-Nieves">Saint-Christophe-et-Niévès</option>
                      <option value="Sainte-Lucie">Sainte-Lucie</option>
                      <option value="Saint-Marin">Saint-Marin </option>
                      <option value="Saint-Siège">Saint-Siège, ou leVatican</option>
                      <option value="Saint-Vincent-et-les_Grenadines">Saint-Vincent-et-les Grenadines</option>
                      <option value="Salomon">Salomon</option>
                      <option value="Salvador">Salvador</option>
                      <option value="Samoa_occidentales">Samoa occidentales</option>
                      <option value="Sao_Tome-et-Principe">Sao Tomé-et-Principe</option>
                      <option value="Senegal">Sénégal</option>
                      <option value="Seychelles">Seychelles</option>
                      <option value="Sierra_Leone">Sierra Leone</option>
                      <option value="Singapour">Singapour</option>
                      <option value="Slovaquie">Slovaquie</option>
                      <option value="Slovenie">Slovénie</option>
                      <option value="Somalie">Somalie</option>
                      <option value="Soudan">Soudan</option>
                      <option value="Sri_Lanka">Sri Lanka</option>
                      <option value="Sued">Suède</option>
                      <option value="Suisse">Suisse</option>
                      <option value="Suriname">Suriname</option>
                      <option value="Swaziland">Swaziland</option>
                      <option value="Syrie">Syrie</option>
                      <option value="Tadjikistan">Tadjikistan</option>
                      <option value="Tanzanie">Tanzanie</option>
                      <option value="Tchad">Tchad</option>
                      <option value="Thailande">Thaïlande</option>
                      <option value="Togo">Togo</option>
                      <option value="Tonga">Tonga</option>
                      <option value="Trinite-et-Tobago">Trinité-et-Tobago</option>
                      <option value="Tunisie">Tunisie</option>
                      <option value="Turkmenistan">Turkménistan</option>
                      <option value="Turquie">Turquie</option>
                      <option value="Tuvalu">Tuvalu</option>
                      <option value="Ukraine">Ukraine</option>
                      <option value="Uruguay">Uruguay</option>
                      <option value="Vanuatu">Vanuatu</option>
                      <option value="Venezuela">Venezuela</option>
                      <option value="Viet_Nam">Viêt Nam</option>
                      <option value="Yemen">Yémen</option>
                      <option value="Yougoslavie">Yougoslavie</option>
                      <option value="Zaire">Zaïre</option>
                      <option value="Zambie">Zambie</option>
                      <option value="Zimbabwe">Zimbabwe</option>
                      </select>
                      
                    </select>
                  </div>
                </div>
                <div class="row mb-2">
                  <div class="col-md-12">
                    <label for="exampleFormControlFile1">Insérez les photos de vos articles</label>
                    <input type="file" name="files[]" placeholder="" class="form-control-file" id="" multiple>
                  </div>
                </div>
                <div class="row">
                  <div class="col-12">
                   
                    <button type="submit" name="submit" class="btn btn-primary w-100 rounded-0 my-3 py-2 px-4">S'Enregistrer</button>
                  <span class="submitting"></span>
                  </div>
                </div>
              </form>

              <div id="form-message-warning mt-4">
              <?php
			        if (isset($message) and !empty($message))
              {
			         	echo "<span style='color:red;'>".$message."</span>";
		          }
		          ?>
              </div> 
              <div id="form-message-success">
              <?php
			        if (isset($message_sucess) and !empty($message_sucess))
              {
			         	echo "<span style='color:green;'>".$message_sucess."</span>";
		          }
		          ?>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
    
    

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js"></script>
    <!--<script src="js/main.js"></script>-->

  </body>
</html>