<?php
/*
Plugin Name:  Validate Form
Plugin URI:   https://tesolteflcouncil.com/
Description:  Validate User Details Form 
Version:      1.0
Author:       Manish Sharma 
Author URI:   https://www.manish-sharma.co.in
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  right-pass
Domain Path:  /languages
*/

register_activation_hook( __FILE__, 'ttcCertificateTable');


function ttcCertificateTable() {
  global $wpdb;
  $charset_collate = $wpdb->get_charset_collate();
  $table_name = $wpdb->prefix . 'certificatetable';
  $sql = "CREATE TABLE `$table_name` (
  `certificate_id` int(20) NOT NULL AUTO_INCREMENT,
  `certificate_no` varchar(40) NOT NULL,
  `passport_name` varchar(80) DEFAULT NULL,
  `passport_number` varchar(80) DEFAULT NULL,
  `date_of_birth` DATE DEFAULT NULL,
  `address` varchar(120) DEFAULT NULL,
  `email` varchar(80) DEFAULT NULL,
  `course` varchar(40) DEFAULT NULL,
  `issue_date` DATE DEFAULT NULL,
  `nationality` varchar(40) DEFAULT NULL,
  `certificate_pdf` MEDIUMBLOB,  
  PRIMARY KEY(certificate_id)
  ) ENGINE=MyISAM DEFAULT CHARSET=latin1;
  ";
  if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
  }
}

add_action('admin_menu', 'addAdminPageContent');

function addAdminPageContent() {
  add_menu_page('Varification', 'Varification', 'manage_options' ,__FILE__, 'varificationAdminPage', 'dashicons-wordpress');
}

function varificationAdminPage() {
  global $wpdb;
  $table_name = $wpdb->prefix . 'certificatetable';
  if (isset($_POST['newsubmit'])) {
    $cert_no = $_POST['certificate_no'];
    $pass_name = $_POST['passport_name'];
    $pass_no = $_POST['passport_no'];
    $dob = $_POST['date_of_birth'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $issue_date = $_POST['issue_date'];
    $nationality = $_POST['nationality'];
    $wpdb->query("INSERT INTO $table_name(certificate_no, passport_name, passport_number, date_of_birth, address, email, course, issue_date, nationality) VALUES('$cert_no', '$pass_name', '$pass_no', '$dob', '$address', '$email', '$course', '$issue_date', '$nationality')");
    echo "<script>location.replace('admin.php?page=validate-form%2Fvalidate-form.php');</script>";
  }
  if (isset($_POST['uptsubmit'])) {
    $id = $_POST['certificate_id'];
    $cert_no = $_POST['certificate_no'];
    $pass_name = $_POST['passport_name'];
    $pass_no = $_POST['passport_number'];
    $dob = $_POST['date_of_birth'];
    $address = $_POST['address'];
    $email = $_POST['email'];
    $course = $_POST['course'];
    $issue_date = $_POST['issue_date'];
    $nationality = $_POST['nationality'];
    $wpdb->query("UPDATE $table_name SET certificate_no='$cert_no', passport_name='$pass_name', passport_number ='$pass_no', date_of_birth='$dob', address='$address', email='$email', course='$course', issue_date='$issue_date', nationality='$nationality'  WHERE certificate_id='$id'");
    echo "<script>location.replace('admin.php?page=validate-form%2Fvalidate-form.php');</script>";
  }
  if (isset($_GET['del'])) {
    $del_id = $_GET['del'];
    $wpdb->query("DELETE FROM $table_name WHERE certificate_id='$del_id'");
    echo "<script>location.replace('admin.php?page=validate-form%2Fvalidate-form.php');</script>";
  }
  ?>
  <div class="wrap">
    <h2>Certficate</h2>
    <table class="wp-list-table widefat striped">
      <thead>
        <tr>
          <th width="5%">Certificate ID</th>
          <th width="10%">Certificate No</th>
          <th width="10%">Passport Name</th>
          <th width="10%">Passport No</th>
          <th width="10%">date_of_birth</th>
          <th width="10%">Address</th>
          <th width="10%">Email</th>
          <th width="5%">Course</th>
          <th width="10%">Issue Date</th>
          <th width="10%">Nationality</th>
          <th width="10%">Actions</th>
        </tr>
      </thead>
      <tbody>
        <form action="" method="post">
          <tr>
            <td><input type="text" value="AUTO_GENERATED" disabled></td>
            <td><input type="text" id="certificate_no" name="certificate_no"></td>
            <td><input type="text" id="passport_name" name="passport_name"></td>
            <td><input type="text" id="passport_no" name="passport_no"></td>
            <td><input type="date" id="date_of_birth" name="date_of_birth"></td>
            <td><input type="text" id="address" name="address"></td>
            <td><input type="email" id="email" name="email"></td>
            <td><input type="text" id="course" name="course"></td>
            <td><input type="date" id="issue_date" name="issue_date"></td>
            <td><input type="text" id="nationality" name="nationality"></td>
            <td><button id="newsubmit" name="newsubmit" type="submit">INSERT</button></td>
          </tr>
        </form>
        <?php
          $result = $wpdb->get_results("SELECT * FROM $table_name");
          foreach ($result as $print) {
            echo "
              <tr>
                <td width='5%'>$print->certificate_id</td>
                <td width='10%'>$print->certificate_no</td>
                <td width='10%'>$print->passport_name</td>
                <td width='10%'>$print->passport_number</td>
                <td width='10%'>$print->date_of_birth</td>
                <td width='10%'>$print->address</td>
                <td width='10%'>$print->email</td>
                <td width='5%'>$print->course</td>
                <td width='10%'>$print->issue_date</td>
                <td width='10%'>$print->nationality</td>
                <td width='10%'><a href='admin.php?page=validate-form%2Fvalidate-form.php&certificate_id=$print->certificate_id'><button type='button'>UPDATE</button></a> <a href='admin.php?page=validate-form%2Fvalidate-form.php&del=$print->certificate_id'><button type='button'>DELETE</button></a></td>
              </tr>
            ";
          }
        ?>
      </tbody>  
    </table>
    <br>
    <br>
    <?php
      if (isset($_GET['certificate_id'])) {
        $upt_id = $_GET['certificate_id'];
        $result = $wpdb->get_results("SELECT * FROM $table_name WHERE certificate_id='$upt_id'");
        foreach($result as $print) {
          $cert_id = $print->certificate_id;
          $cert_no = $print->certificate_no;
        }
        echo "
        <table class='wp-list-table widefat striped'>
          <thead>
            <tr>
              <th width='5%'>Certificate ID</th>
              <th width='10%'>Certificate No</th>
              <th width='10%'>Passport Name</th>
              <th width='10%'>Passport No</th>
              <th width='10%'>date_of_birth</th>
              <th width='10%'>Address</th>
              <th width='10%'>Email</th>
              <th width='5%'>Course</th>
              <th width='10%'>Issue Date</th>
              <th width='10%'>Nationality</th>
              <th width='10%'>Actions</th>
            </tr>
          </thead>
          <tbody>
            <form action='' method='post'>
              <tr>
                <td width='5%'>
                  $print->certificate_id 
                  <input type='hidden' id='certificate_id' name='certificate_id' value='$print->certificate_id'>
                </td>
                <td width='10%'>
                  <input type='text' id='certificate_no' name='certificate_no' value='$print->certificate_no'>
                </td>
                <td width='10%'>
                  <input type='text' id='passport_name' name='passport_name' value='$print->passport_name'>
                </td>
                <td width='10%'>
                  <input type='text' id='passport_number' name='passport_number' value='$print->passport_number'>
                </td>
                <td width='10%'>
                  <input type='date' id='date_of_birth' name='date_of_birth' value='$print->date_of_birth'>
                </td>
                <td width='10%'>
                  <input type='text' id='address' name='address' value='$print->address'>
                </td>
                <td width='10%'>
                  <input type='email' id='email' name='email' value='$print->email'>
                </td>
                <td width='5%'>
                  <input type='text' id='course' name='course' value='$print->course'>
                </td>
                <td width='10%'>
                  <input type='date' id='issue_date' name='issue_date' value='$print->issue_date'>
                </td>
                <td width='10%'>
                  <input type='text' id='nationality' name='nationality' value='$print->nationality'>
                </td>
                <td width='10%'>
                  <button id='uptsubmit' name='uptsubmit' type='submit'>
                    UPDATE
                  </button> 
                  <a href='admin.php?page=validate-form%2Fvalidate-form.php'>
                    <button type='button'>CANCEL</button>
                  </a>
                </td>
              </tr>
            </form>
          </tbody>
        </table>";
      }
    ?>
  </div>
  <?php
}
