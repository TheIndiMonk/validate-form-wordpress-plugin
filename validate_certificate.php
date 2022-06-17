 <?php
 function validate_certificate($atts) {
	$Content = '';
	$Content .= '<div class="certificate-form d-flex flex-column my-1">
                        <form class="mb-5" action="" method="POST">
                            <div class="d-flex flex-column py-1">
                                <div class="cert-icon py-1">
                                    <img src="http://tesolteflcouncil.com/wp-content/uploads/2022/05/cropped-cropped-TTC-LOGO-PNG.png" alt="Logo"></div>
                                <h2 class="text-center">Verify your Certificate</h2>
                                <div class="line my-3"></div>
                                <label class="panda-label my-1" for="passportName"> Name</label>
                                <input type="text" class="form-control panda-input text-white my-1"
                                    id="passportName"
                                    name="passportName"
                                    placeholder="Enter Your Full Name">
                                <label class="panda-label my-1" for="passportNo"> Passport No</label>
                                <input type="text" class="form-control panda-input text-white my-1"
                                    id="passportNo"
                                    name="passportNo"
                                    placeholder="Enter Your Passport No" >
                                <label class="panda-label" for="certificateId"> Certificate ID</label>
                                <input type="text" class="form-control panda-input text-white my-1"
                                    id="certificateId"
                                    name="certificateId"
                                    placeholder="Enter Your Certificate ID Here e.g. ( TTC-42-243068 )">
                                <button type="submit" class="panda-btn btn-primary my-2">Search</button>
                            </div>
                        </form>
                    </div>';
	 
    return $Content;
}


add_shortcode('validate_certificate_form', 'validate_certificate');

?>