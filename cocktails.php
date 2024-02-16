<?php
@include 'config.php';
session_start();

// Check if age is not verified
if (!isset($_SESSION["age_verified"]) || $_SESSION["age_verified"] !== true) {
    // Age not verified, redirect to age verification page
    header("Location: verifyage.php");
    exit(); // Stop further execution
}

@include 'commentfunction.php';

// Check if the user is logged in
$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$logged_in = !empty($user_id);

$page_identifier = isset($_POST['pageIdentifier']) ? $_POST['pageIdentifier'] : '';

// Posting Comments
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $logged_in) {
    // Process comment submission
    $comment = $_POST['comment'];
    if (!empty($comment)) {
        insert_comment($user_id, $comment, $page_identifier); // Pass the page identifier to insert_comment
        // Redirect to prevent form resubmission
        header("Location: cocktails.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/split-type"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.4.1.min.js"></script>
    <script src="https://kit.fontawesome.com/6eb243e274.js" crossorigin="anonymous"></script>

    <style>
@font-face {
font-family: "DancingScript";
src: url("fontit/DancingScript-Regular.otf");

font-family: "DancingScriptBold";
src: url("fontit/DancingScript-Bold.otf");

font-family: "JosefinSans"
src: url("fontit/JosefinSans-Regular.ttf");

font-family: "JosefinSansBold"
src: url("fontit/JosefinSans-Bold.ttf");
}

h1 {
    font-family: 'DancingScriptBold';
}

h2 {
    font-family: 'JosefinSans';
    letter-spacing: 1px;
}

p {
    font-family: 'JosefinSans';
    letter-spacing: 1px;
}


.container2{
    width: 100%;
    height: 100%;
    max-width: 600px;
    max-height: 600px;
    display: flex;
    justify-content: center;
    align-items: center;
    transform-style: preserve-3d;
    flex-direction: column;
    margin-bottom: 100px;
}

.cards{
    position: relative;
    height: 500px;
    width: 430px;
    margin-bottom: 20px;
    perspective: 1000px;
    transform-style: preserve-3d;
}

.cards label{
    position: absolute;
    width: 430px;
    left: 0;
    right: 0;
    margin: auto;
    cursor: pointer;
    transition: transform 0.55s ease;
}

.cards .card{
    position: relative;
    height: 100%;
    background-color: #242422;
    border-radius: 10px;
    padding: 30px 35px;
    border: solid 1px #7e7e7c;
}

.cards .image{
    display: flex;
    justify-content: space-between;
}

.cards .image img{
    border-radius: 5px;
    box-shadow: 15px 15px 40px rgba(0,0,0, 50%);
    margin-top: 5px;
    width: 100%;
    height: 350px;
    object-fit: cover;
    transition: all .7s;
}

.cards .image img:hover {
    transform: scale(1.05);
}

.card .image {
    text-align: center;
}

.card .infos {
    display: block;
    text-align: center;
    padding-top: 30px;
}

.card .infos span {
    display: block;
}

.infos .name {
    font-size: 30px;
    color: var(--current-color1);
    letter-spacing: 1px;
    margin-bottom: 20px;
    transition: all .6s ease;
}

.card .lorem {
    font-size: 20px;
    color: #eceaed;
    letter-spacing: 1px;
}

.card .btn-details {
    width: 100%;
    height: 60px;
    margin: 35px auto;
    border-radius: 5px;
    background-color: var(--current-color1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #000;
    font-size: 25px;
    letter-spacing: 4px;
    font-weight: 700;
    transition: all .7s ease;
}

.card .btn-details:hover {
    transform: scale(1.1);
}

.card .actions {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding-top: 20px;
}



input#s1, input#s2, input#s3, input#s4, input#s5, input#s6, input#s7, input#s8, input#s9, input#s10, input#s11,
input#s12, input#s13, input#s14, input#s15, input#s16, input#s17, input#s18, input#s19, input#s20 {
    display: none;
}


/*Like counter*/

.heart-icon {
  user-select: none;
  fill: transparent;
}

.heart-icon:hover path {
    stroke: #e74c3c; 
    transition: stroke 0.3s ease;
}

.heart-icon .fill-color-shape {
  fill: transparent;
}

.heart-icon.isLiked path {
    fill: #e74c3c;
    stroke: #e74c3c;
}

.number-of-likes {
  font-size: 17px;
  user-select: none;
  color: #fff;
  user-select: none;
  margin-left: 0.5rem;
}

.actions i {
    font-size: 24px;
    transition: all .7s ease;
    color: white
}

.actions:hover svg {
    transform: scale(1.1);
}

.actions:hover i {
    transform: scale(1.1);
}


/*Card Slider Section 1*/ 

@media (min-width: 640px) { 
#s1:checked~.cards #slide4,
#s2:checked~.cards #slide5,
#s3:checked~.cards #slide1,
#s4:checked~.cards #slide2,
#s5:checked~.cards #slide3{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-40%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide5,
#s2:checked~.cards #slide1,
#s3:checked~.cards #slide2,
#s4:checked~.cards #slide3,
#s5:checked~.cards #slide4{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-30%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide1,
#s2:checked~.cards #slide2,
#s3:checked~.cards #slide3,
#s4:checked~.cards #slide4,
#s5:checked~.cards #slide5{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide2,
#s2:checked~.cards #slide3,
#s3:checked~.cards #slide4,
#s4:checked~.cards #slide5,
#s5:checked~.cards #slide1{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(30%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide3,
#s2:checked~.cards #slide4,
#s3:checked~.cards #slide5,
#s4:checked~.cards #slide1,
#s5:checked~.cards #slide2{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(40%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}

@media (min-width: 768px) { 
#s1:checked~.cards #slide4,
#s2:checked~.cards #slide5,
#s3:checked~.cards #slide1,
#s4:checked~.cards #slide2,
#s5:checked~.cards #slide3{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-45%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide5,
#s2:checked~.cards #slide1,
#s3:checked~.cards #slide2,
#s4:checked~.cards #slide3,
#s5:checked~.cards #slide4{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-35%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide1,
#s2:checked~.cards #slide2,
#s3:checked~.cards #slide3,
#s4:checked~.cards #slide4,
#s5:checked~.cards #slide5{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide2,
#s2:checked~.cards #slide3,
#s3:checked~.cards #slide4,
#s4:checked~.cards #slide5,
#s5:checked~.cards #slide1{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(35%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide3,
#s2:checked~.cards #slide4,
#s3:checked~.cards #slide5,
#s4:checked~.cards #slide1,
#s5:checked~.cards #slide2{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(45%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}


@media (min-width: 1024px) { 
#s1:checked~.cards #slide4,
#s2:checked~.cards #slide5,
#s3:checked~.cards #slide1,
#s4:checked~.cards #slide2,
#s5:checked~.cards #slide3{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-85%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide5,
#s2:checked~.cards #slide1,
#s3:checked~.cards #slide2,
#s4:checked~.cards #slide3,
#s5:checked~.cards #slide4{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-45%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide1,
#s2:checked~.cards #slide2,
#s3:checked~.cards #slide3,
#s4:checked~.cards #slide4,
#s5:checked~.cards #slide5{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide2,
#s2:checked~.cards #slide3,
#s3:checked~.cards #slide4,
#s4:checked~.cards #slide5,
#s5:checked~.cards #slide1{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(45%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide3,
#s2:checked~.cards #slide4,
#s3:checked~.cards #slide5,
#s4:checked~.cards #slide1,
#s5:checked~.cards #slide2{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(85%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}

@media (min-width: 1536px) { 
#s1:checked~.cards #slide4,
#s2:checked~.cards #slide5,
#s3:checked~.cards #slide1,
#s4:checked~.cards #slide2,
#s5:checked~.cards #slide3{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-130%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide5,
#s2:checked~.cards #slide1,
#s3:checked~.cards #slide2,
#s4:checked~.cards #slide3,
#s5:checked~.cards #slide4{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-65%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide1,
#s2:checked~.cards #slide2,
#s3:checked~.cards #slide3,
#s4:checked~.cards #slide4,
#s5:checked~.cards #slide5{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #f9d342;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide2,
#s2:checked~.cards #slide3,
#s3:checked~.cards #slide4,
#s4:checked~.cards #slide5,
#s5:checked~.cards #slide1{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(65%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s1:checked~.cards #slide3,
#s2:checked~.cards #slide4,
#s3:checked~.cards #slide5,
#s4:checked~.cards #slide1,
#s5:checked~.cards #slide2{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(130%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}

/*SECTION 2 SLIDER START*/

@media (min-width: 640px) { 
#s6:checked~.cards #slide9,
#s7:checked~.cards #slide10,
#s8:checked~.cards #slide6,
#s9:checked~.cards #slide7,
#s10:checked~.cards #slide8{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-40%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide10,
#s7:checked~.cards #slide6,
#s8:checked~.cards #slide7,
#s9:checked~.cards #slide8,
#s10:checked~.cards #slide9{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-30%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide6,
#s7:checked~.cards #slide7,
#s8:checked~.cards #slide8,
#s9:checked~.cards #slide9,
#s10:checked~.cards #slide10{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide7,
#s7:checked~.cards #slide8,
#s8:checked~.cards #slide9,
#s9:checked~.cards #slide10,
#s10:checked~.cards #slide6{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(30%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide8,
#s7:checked~.cards #slide9,
#s8:checked~.cards #slide10,
#s9:checked~.cards #slide6,
#s10:checked~.cards #slide7{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(40%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}

@media (min-width: 768px) { 
#s6:checked~.cards #slide9,
#s7:checked~.cards #slide10,
#s8:checked~.cards #slide6,
#s9:checked~.cards #slide7,
#s10:checked~.cards #slide8{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-45%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide10,
#s7:checked~.cards #slide6,
#s8:checked~.cards #slide7,
#s9:checked~.cards #slide8,
#s10:checked~.cards #slide9{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-35%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide6,
#s7:checked~.cards #slide7,
#s8:checked~.cards #slide8,
#s9:checked~.cards #slide9,
#s10:checked~.cards #slide10{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide7,
#s7:checked~.cards #slide8,
#s8:checked~.cards #slide9,
#s9:checked~.cards #slide10,
#s10:checked~.cards #slide6{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(35%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide8,
#s7:checked~.cards #slide9,
#s8:checked~.cards #slide10,
#s9:checked~.cards #slide6,
#s10:checked~.cards #slide7{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(45%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}


@media (min-width: 1024px) { 
#s6:checked~.cards #slide9,
#s7:checked~.cards #slide10,
#s8:checked~.cards #slide6,
#s9:checked~.cards #slide7,
#s10:checked~.cards #slide8{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-85%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide10,
#s7:checked~.cards #slide6,
#s8:checked~.cards #slide7,
#s9:checked~.cards #slide8,
#s10:checked~.cards #slide9{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-45%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide6,
#s7:checked~.cards #slide7,
#s8:checked~.cards #slide8,
#s9:checked~.cards #slide9,
#s10:checked~.cards #slide10{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide7,
#s7:checked~.cards #slide8,
#s8:checked~.cards #slide9,
#s9:checked~.cards #slide10,
#s10:checked~.cards #slide6{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(45%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide8,
#s7:checked~.cards #slide9,
#s8:checked~.cards #slide10,
#s9:checked~.cards #slide6,
#s10:checked~.cards #slide7{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(85%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}

@media (min-width: 1536px) { 
#s6:checked~.cards #slide9,
#s7:checked~.cards #slide10,
#s8:checked~.cards #slide6,
#s9:checked~.cards #slide7,
#s10:checked~.cards #slide8{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-130%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide10,
#s7:checked~.cards #slide6,
#s8:checked~.cards #slide7,
#s9:checked~.cards #slide8,
#s10:checked~.cards #slide9{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-65%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide6,
#s7:checked~.cards #slide7,
#s8:checked~.cards #slide8,
#s9:checked~.cards #slide9,
#s10:checked~.cards #slide10{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #f9d342;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide7,
#s7:checked~.cards #slide8,
#s8:checked~.cards #slide9,
#s9:checked~.cards #slide10,
#s10:checked~.cards #slide6{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(65%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s6:checked~.cards #slide8,
#s7:checked~.cards #slide9,
#s8:checked~.cards #slide10,
#s9:checked~.cards #slide6,
#s10:checked~.cards #slide7{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(130%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}

/*SECTION 3 SLIDER START*/

@media (min-width: 640px) { 
#s11:checked~.cards #slide14,
#s12:checked~.cards #slide15,
#s13:checked~.cards #slide11,
#s14:checked~.cards #slide12,
#s15:checked~.cards #slide13{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-40%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide15,
#s12:checked~.cards #slide11,
#s13:checked~.cards #slide12,
#s14:checked~.cards #slide13,
#s15:checked~.cards #slide14{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-30%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide11,
#s12:checked~.cards #slide12,
#s13:checked~.cards #slide13,
#s14:checked~.cards #slide14,
#s15:checked~.cards #slide15{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide12,
#s12:checked~.cards #slide13,
#s13:checked~.cards #slide14,
#s14:checked~.cards #slide15,
#s15:checked~.cards #slide11{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(30%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide13,
#s12:checked~.cards #slide14,
#s13:checked~.cards #slide15,
#s14:checked~.cards #slide11,
#s15:checked~.cards #slide12{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(40%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}

@media (min-width: 768px) { 
#s11:checked~.cards #slide14,
#s12:checked~.cards #slide15,
#s13:checked~.cards #slide11,
#s14:checked~.cards #slide12,
#s15:checked~.cards #slide13{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-45%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide15,
#s12:checked~.cards #slide11,
#s13:checked~.cards #slide12,
#s14:checked~.cards #slide13,
#s15:checked~.cards #slide14{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-35%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide11,
#s12:checked~.cards #slide12,
#s13:checked~.cards #slide13,
#s14:checked~.cards #slide14,
#s15:checked~.cards #slide15{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide12,
#s12:checked~.cards #slide13,
#s13:checked~.cards #slide14,
#s14:checked~.cards #slide15,
#s15:checked~.cards #slide11{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(35%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide13,
#s12:checked~.cards #slide14,
#s13:checked~.cards #slide15,
#s14:checked~.cards #slide11,
#s15:checked~.cards #slide12{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(45%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}


@media (min-width: 1024px) { 
#s11:checked~.cards #slide14,
#s12:checked~.cards #slide15,
#s13:checked~.cards #slide11,
#s14:checked~.cards #slide12,
#s15:checked~.cards #slide13{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-85%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide15,
#s12:checked~.cards #slide11,
#s13:checked~.cards #slide12,
#s14:checked~.cards #slide13,
#s15:checked~.cards #slide14{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-45%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide11,
#s12:checked~.cards #slide12,
#s13:checked~.cards #slide13,
#s14:checked~.cards #slide14,
#s15:checked~.cards #slide15{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide12,
#s12:checked~.cards #slide13,
#s13:checked~.cards #slide14,
#s14:checked~.cards #slide15,
#s15:checked~.cards #slide11{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(45%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide13,
#s12:checked~.cards #slide14,
#s13:checked~.cards #slide15,
#s14:checked~.cards #slide11,
#s15:checked~.cards #slide12{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(85%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}

@media (min-width: 1536px) { 
#s11:checked~.cards #slide14,
#s12:checked~.cards #slide15,
#s13:checked~.cards #slide11,
#s14:checked~.cards #slide12,
#s15:checked~.cards #slide13{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-130%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide15,
#s12:checked~.cards #slide11,
#s13:checked~.cards #slide12,
#s14:checked~.cards #slide13,
#s15:checked~.cards #slide14{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-65%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide11,
#s12:checked~.cards #slide12,
#s13:checked~.cards #slide13,
#s14:checked~.cards #slide14,
#s15:checked~.cards #slide15{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #f9d342;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide12,
#s12:checked~.cards #slide13,
#s13:checked~.cards #slide14,
#s14:checked~.cards #slide15,
#s15:checked~.cards #slide11{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(65%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s11:checked~.cards #slide13,
#s12:checked~.cards #slide14,
#s13:checked~.cards #slide15,
#s14:checked~.cards #slide11,
#s15:checked~.cards #slide12{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(130%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}

/*SECTION 4 SLIDER START*/

@media (min-width: 640px) { 
#s16:checked~.cards #slide19,
#s17:checked~.cards #slide20,
#s18:checked~.cards #slide16,
#s19:checked~.cards #slide17,
#s20:checked~.cards #slide18{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-40%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide20,
#s17:checked~.cards #slide16,
#s18:checked~.cards #slide17,
#s19:checked~.cards #slide18,
#s20:checked~.cards #slide19{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-30%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide16,
#s17:checked~.cards #slide17,
#s18:checked~.cards #slide18,
#s19:checked~.cards #slide19,
#s20:checked~.cards #slide20{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide17,
#s17:checked~.cards #slide18,
#s18:checked~.cards #slide19,
#s19:checked~.cards #slide20,
#s20:checked~.cards #slide16{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(30%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide18,
#s17:checked~.cards #slide19,
#s18:checked~.cards #slide20,
#s19:checked~.cards #slide16,
#s20:checked~.cards #slide17{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(40%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}

@media (min-width: 768px) { 
#s16:checked~.cards #slide19,
#s17:checked~.cards #slide20,
#s18:checked~.cards #slide16,
#s19:checked~.cards #slide17,
#s20:checked~.cards #slide18{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-45%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide20,
#s17:checked~.cards #slide16,
#s18:checked~.cards #slide17,
#s19:checked~.cards #slide18,
#s20:checked~.cards #slide19{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-35%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide16,
#s17:checked~.cards #slide17,
#s18:checked~.cards #slide18,
#s19:checked~.cards #slide19,
#s20:checked~.cards #slide20{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide17,
#s17:checked~.cards #slide18,
#s18:checked~.cards #slide19,
#s19:checked~.cards #slide20,
#s20:checked~.cards #slide16{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(35%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide18,
#s17:checked~.cards #slide19,
#s18:checked~.cards #slide20,
#s19:checked~.cards #slide16,
#s20:checked~.cards #slide17{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(45%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}


@media (min-width: 1024px) { 
#s16:checked~.cards #slide19,
#s17:checked~.cards #slide20,
#s18:checked~.cards #slide16,
#s19:checked~.cards #slide17,
#s20:checked~.cards #slide18{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-85%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide20,
#s17:checked~.cards #slide16,
#s18:checked~.cards #slide17,
#s19:checked~.cards #slide18,
#s20:checked~.cards #slide19{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-45%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide16,
#s17:checked~.cards #slide17,
#s18:checked~.cards #slide18,
#s19:checked~.cards #slide19,
#s20:checked~.cards #slide20{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #fad00c;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide17,
#s17:checked~.cards #slide18,
#s18:checked~.cards #slide19,
#s19:checked~.cards #slide20,
#s20:checked~.cards #slide16{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(45%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide18,
#s17:checked~.cards #slide19,
#s18:checked~.cards #slide20,
#s19:checked~.cards #slide16,
#s20:checked~.cards #slide17{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(85%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}

@media (min-width: 1536px) { 
#s16:checked~.cards #slide19,
#s17:checked~.cards #slide20,
#s18:checked~.cards #slide16,
#s19:checked~.cards #slide17,
#s20:checked~.cards #slide18{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(-130%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide20,
#s17:checked~.cards #slide16,
#s18:checked~.cards #slide17,
#s19:checked~.cards #slide18,
#s20:checked~.cards #slide19{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(-65%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide16,
#s17:checked~.cards #slide17,
#s18:checked~.cards #slide18,
#s19:checked~.cards #slide19,
#s20:checked~.cards #slide20{

    box-shadow: 0 25px 50px rgba(0, 0, 0, 50%);
    transform: translate3d(0, 0, 0);
    --current-color1: #f9d342;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide17,
#s17:checked~.cards #slide18,
#s18:checked~.cards #slide19,
#s19:checked~.cards #slide20,
#s20:checked~.cards #slide16{

    box-shadow: 0 20px 40px rgba(0, 0, 0, 45%);
    transform: translate3d(65%, 0, -120px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}

#s16:checked~.cards #slide18,
#s17:checked~.cards #slide19,
#s18:checked~.cards #slide20,
#s19:checked~.cards #slide16,
#s20:checked~.cards #slide17{

    box-shadow: 0 15px 30px rgba(0, 0, 0, 45%);
    transform: translate3d(130%, 0, -220px);
    --current-color1: #eceaed;
    --currente-color2: #eceaed;
}
}
</style>
</head>

<?php include_once('header.php');?>  

<body class="bg-cover bg-no-repeat bg-center" style="background-image: url('img/mainbg.png')">


  <!--Banneri alkaa-->
  <section style="background-image: url('img/cocktailsbanneri.png'); background-repeat: no-repeat; width: 100%; margin-top: -10rem; background-size: cover; height: 105vh; overflow: hidden;">
  <div style="width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center;">
    <div class="text-center text-white">
      <h1 class="animate-heading2 mb-4 text-9xl">Cocktails</h1>
      <p class="animate-heading2 font-serif text-xl">Drink responsibly</p>
    </div>
  </div>
</section>

<!--Search banner-->
<section class="my-10">
    <div class="mx-auto max-w-screen-2xl px-4 md:px-8">
        <div class="flex flex-col mx-auto py-10 px-10 justify-center items-center text-center bg-[#f9d342] rounded-lg">
            <h1 class="text-[#292826] font-semibold text-6xl mb-10">Search for your<br /> favourite drinks</h1>
            <form action="search.php" method="GET" class="relative flex items-center w-2/3 max-w-[600px] h-12 rounded-lg focus-within:shadow-lg overflow-hidden bg-white">
    <div class="grid place-items-center h-full w-12 text-gray-300">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="black">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
    <input
        class="peer h-full w-4/5 outline-none text-sm text-gray-700 pr-2"
        type="text"
        name="keywords"
        id="searchInput"
        placeholder="Search something.."
        style="color: #4B5563;"
    />
    <button type="submit" class="absolute right-0 top-0 bottom-0 px-3 flex items-center justify-center bg-gray-200 hover:bg-gray-300 focus:bg-gray-300 text-gray-800 hover:text-gray-900 focus:text-gray-900 border-l border-gray-300 focus:outline-none">
        Search
    </button>
</form>
        </div>
    </div>
</section>


<section class="my-20 flex flex-col justify-center items-center text-center">
    <h2 class="text-4xl text-white uppercase mb-8">Our recommendations</h2>
   <div class="flex"> 
    <button class="scroll-button py-2 px-6 rounded-lg border border-white text-white mr-3 font-bold" data-target="vodka">Vodka</button>
    <button class="scroll-button py-2 px-6 rounded-lg border border-white text-white mr-3 font-bold" data-target="gin">Gin</button>
    <button class="scroll-button py-2 px-6 rounded-lg border border-white text-white mr-3 font-bold" data-target="rum">Rum</button>
    <button class="scroll-button py-2 px-6 rounded-lg border border-white text-white font-bold" data-target="tequila">Tequila</button> 
</div>  
</section>


<!--Slider section-->
<div class="max-w-screen-2xl mx-auto px-4 mx:px-8 mt-20" id="vodka">
<h2 class="flex justify-center items-center text-center text-white text-3xl max-w-screen-2xl px-4 mb-10 lg:px-14 xl:px-30 2xl:px-16">
    Vodka based
</h2>
</div>
<section class="flex justify-center align-center pb-40 max-w-screen-2xl mx-auto px-4 overflow-hidden">
    <div class="container2">
        <input type="radio" name="slider" id="s1" checked>
        <input type="radio" name="slider" id="s2">
        <input type="radio" name="slider" id="s3">
        <input type="radio" name="slider" id="s4">
        <input type="radio" name="slider" id="s5">

        <div class="cards">
            <!--Slider kortti-->
            <label for="s1" id="slide1">
                <div class="card">
                    <div class="image">
                        <img src="img/citrusfizz.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Citrus Fizz</span>
                    
                        <a href="citrus_fizz.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_101">
                            <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_101"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'citrus_fizz.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s2" id="slide2">
                <div class="card">
                    <div class="image">
                        <img src="img/peachicedtea.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Peach Iced Tea</span>
                        <a href="peach_iced_tea.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_102">
                            <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_102"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'peach_iced_tea.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s3" id="slide3">
                <div class="card">
                    <div class="image">
                        <img src="img/handsomeginger.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Handsome Ginger</span>
                        <a href="handsome_ginger.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_103">
                            <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_103"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'handsome_ginger.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s4" id="slide4">
                <div class="card">
                    <div class="image">
                        <img src="img/hakuhighball.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Haku Highball</span>
                        <a href="haku_highball.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_104">
                            <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_104"></span>
                            </div>
                            <i class="fa-regular fa-comment"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s5" id="slide5">
                <div class="card">
                    <div class="image">
                        <img src="img/cucumbercooler.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Cucumber Cooler</span>
                        <a href="cucumber_cooler.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_105">
                            <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_105"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'cucumber_cooler.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>
</section>

<!--Slider section 2-->
<div class="max-w-screen-2xl mx-auto px-4 mx:px-8" id="gin">
<h2 class="flex justify-center items-center text-center text-white text-3xl max-w-screen-2xl px-4 mb-10 lg:px-14 xl:px-30 2xl:px-16">
    Gin based
</h2>
</div>
<section class="flex justify-center align-center pb-40 max-w-screen-2xl mx-auto px-4 overflow-hidden">
    <div class="container2">
        <input type="radio" name="slider2" id="s6" checked>
        <input type="radio" name="slider2" id="s7">
        <input type="radio" name="slider2" id="s8">
        <input type="radio" name="slider2" id="s9">
        <input type="radio" name="slider2" id="s10">

        <div class="cards">
            <!--Slider kortti-->
            <label for="s6" id="slide6">
                <div class="card">
                    <div class="image">
                        <img src="img/japaneseginsour.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Japanese Gin Sour</span>
                        <a href="japanese_gin_sour.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_106">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_106"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'japanese_gin_sour.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s7" id="slide7">
                <div class="card">
                    <div class="image">
                        <img src="img/rokuginsonic.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Roku Gin Sonic</span>
                        <a href="roku_gin_sonic.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_107">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_107"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'roku_gin_sonic.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s8" id="slide8">
                <div class="card">
                    <div class="image">
                        <img src="img/sloeginfizz.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Sloe Gin Fizz</span>
                        <a href="sloe_gin_fizz.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_108">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_108"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'sloe_gin_fizz.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s9" id="slide9">
                <div class="card">
                    <div class="image">
                        <img src="img/gintonic.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Gin Tonic</span>
                        <a href="gin_tonic.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_109">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_109"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'gin_tonic.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s10" id="slide10">
                <div class="card">
                    <div class="image">
                        <img src="img/sipsmithmartini.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Sipsmith&reg; Martini</span>
                        <a href="sipsmith_martini.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_110">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_110"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'sipsmith_martini.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>
</section>

<!--Slider section 3-->
<div class="max-w-screen-2xl mx-auto px-4 mx:px-8" id="rum">
<h2 class="flex justify-center items-center text-center text-white text-3xl max-w-screen-2xl px-4 mb-10 lg:px-14 xl:px-30 2xl:px-16">
    Rum based
</h2>
</div>
<section class="flex justify-center align-center pb-40 max-w-screen-2xl mx-auto px-4 overflow-hidden">
    <div class="container2">
        <input type="radio" name="slider3" id="s11" checked>
        <input type="radio" name="slider3" id="s12">
        <input type="radio" name="slider3" id="s13">
        <input type="radio" name="slider3" id="s14">
        <input type="radio" name="slider3" id="s15">

        <div class="cards">
            <!--Slider kortti-->
            <label for="s11" id="slide11">
                <div class="card">
                    <div class="image">
                        <img src="img/cruzanconfusion.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Cruzan&reg; Confusion</span>
                        <a href="cruzan_confusion.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_111">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_111"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'cruzan_confusion.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
<!--Slider kortti-->
<label for="s12" id="slide12">
    <div class="card">
        <div class="image">
            <img src="img/maitai.jpg" alt="">
        </div>
        <div class="infos">
            <span class="name">Mai Tai</span>
            <a href="mai_tai.php" class="btn-details">Recipe</a>
            <div class="actions" id="card_112">
                <div class="flex">
                    <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                        <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="number-of-likes" data-card-id="card_112"></span>
                </div>
                <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'mai_tai.php')"></i>
                <i class="fa-solid fa-share-nodes"></i>
            </div>
        </div>
    </div>
</label>
            <!--Slider kortti-->
            <label for="s13" id="slide13">
                <div class="card">
                    <div class="image">
                        <img src="img/peachdaiquri.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Peach Daiquri</span>
                        <a href="peach_daiquri.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_113">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_113"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'peach_daiquri.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s14" id="slide14">
                <div class="card">
                    <div class="image">
                        <img src="img/hottoddy.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Hot Toddy</span>
                        <a href="hot_toddy.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_114">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_114"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'hot_toddy.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s15" id="slide15">
                <div class="card">
                    <div class="image">
                        <img src="img/cranberrymojito.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Cranberry Mojito</span>
                        <a href="cranberry_mojito.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_115">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_115"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'cranberry_mojito.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
        </div>
    </div>
</section>

<!--Slider section 4-->
<div class="max-w-screen-2xl mx-auto px-4 mx:px-8" id="tequila">
<h2 class="flex justify-center items-center text-center text-white text-3xl max-w-screen-2xl px-4 mb-10 lg:px-14 xl:px-30 2xl:px-16">
    Tequila based
</h2>
</div>
<section class="flex justify-center align-center pb-40 max-w-screen-2xl mx-auto px-4 overflow-hidden">
    <div class="container2">
        <input type="radio" name="slider4" id="s16" checked>
        <input type="radio" name="slider4" id="s17">
        <input type="radio" name="slider4" id="s18">
        <input type="radio" name="slider4" id="s19">
        <input type="radio" name="slider4" id="s20">

        <div class="cards">
            <!--Slider kortti-->
            <label for="s16" id="slide16">
                <div class="card">
                    <div class="image">
                        <img src="img/donfranciscomargarita.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Don Francisco Margarita</span>
                    
                        <a href="don_francisco_margarita.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_116">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_116"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'don_francisco_margarita.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s17" id="slide17">
                <div class="card">
                    <div class="image">
                        <img src="img/tequilabaybreeze.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">Tequila Baybreeze</span>
                        <a href="tequila_bay_breeze.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_117">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_117"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'tequila_bay_breeze.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s18" id="slide18">
                <div class="card">
                    <div class="image">
                        <img src="img/tequilasunrise.jpg" alt="" data-page-identifier="tequila_sunrise.php">
                    </div>
                    <div class="infos">
                        <span class="name">Tequila Sunrise</span>
                        <a href="tequila_sunrise.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_118">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_118"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'tequila_sunrise.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
            <!--Slider kortti-->
            <label for="s19" id="slide19" >
                <div class="card">
                    <div class="image">
                        <img src="img/elbombin.jpg" alt="">
                    </div>
                    <div class="infos">
                        <span class="name">El Bombin</span>
                        <a href="el_bombin.php" class="btn-details">Recipe</a>
                        <div class="actions" id="card_119">
                        <div class="flex">
                            <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                            <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                    <span class="number-of-likes" data-card-id="card_119"></span>
                            </div>
                            <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'el_bombin.php')"></i>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                    </div>
                </div>
            </label>
<!--Slider kortti-->
<label for="s20" id="slide20" >
    <div class="card">
        <div class="image">
            <img src="img/hornitospaloma.jpg" alt="">
        </div>
        <div class="infos">
            <span class="name">Classic Hornitos Paloma</span>
            <a href="classic_hornitos_paloma.php" class="btn-details">Recipe</a>
            <div class="actions" id="card_120">
                <div class="flex">
                    <svg class="heart-icon object-center transition duration-200" width="24" height="24" fill="none" xmlns="http://www.w3.org/2000/svg" onclick="like(this)">
                        <path d="M12 21.35L10.55 20.03C5.4 15.36 2 12.27 2 8.5C2 5.42 4.42 3 7.5 3C9.24 3 10.97 3.81 12 5.12C13.03 3.81 14.76 3 16.5 3C19.58 3 22 5.42 22 8.5C22 12.27 18.6 15.36 13.45 20.03L12 21.35Z" fill="none" stroke="#ffffff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="number-of-likes" data-card-id="card_120"></span>
                </div>
                <i class="fa-regular fa-comment" onclick="openCommentModal(this, 'classic_hornitos_paloma.php')"></i>
                <i class="fa-solid fa-share-nodes"></i>
            </div>
        </div>
    </div>
</label>
        </div>
    </div>
</section>

<!-- The Modal -->
<div class="flex justify-center items-center fixed" id="commentModal" style="display: none;">
    <!-- Modal content -->
    <div class="bg-white p-6 rounded-lg">
        <form id="commentForm" action="" method="post">
            <div class="flex flex-col"> <!-- Use flexbox to align content -->
                <label for="commentInput" class="mb-2 font-semibold text-lg">Comment</label> <!-- Move "Comment:" text to top left -->
                <textarea id="commentInput" name="comment" rows="4" cols="50" class="mb-4"></textarea> <!-- Add margin-bottom for spacing -->
                <!-- Add hidden input field for pageIdentifier -->
                <input type="hidden" id="pageIdentifier" name="pageIdentifier" value="">
                <div class="flex justify-between"> <!-- Use flexbox to align buttons -->
                    <button type="submit" class="bg-[#f9d342] text-[#292826] py-2 px-4 rounded-lg">Submit</button>
                    <button type="button" onclick="hideCommentField()">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>


<!--Banner animation-->
<script>
    // SplitType and gsap animations for the second set of elements
    let typeSplit2 = new SplitType('.animate-heading2', {
        types: 'lines, words, chars',
        tagName: 'span'
    });

    const tlSplit2 = gsap.timeline({ defaults: { ease: 'Power4.easeOut' } });

    tlSplit2.from('.animate-heading2', {
        y: '-150%',
        opacity: 0,
        duration: 1.5,
        stagger: 0.3
    });

</script>

<!--Like filter-->
<script>
function like(button) {
    var cardId = button.nextElementSibling.dataset.cardId;
    var likeCountElement = document.querySelector(`[data-card-id="${cardId}"]`);

    if (!button.classList.contains('isLiked')) {
        var currentCount = parseInt(likeCountElement.textContent);
        likeCountElement.textContent = currentCount + 1;
        button.classList.add('isLiked');

        // Send AJAX request to store like in database
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'store_likes.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                // Update like count element with the received value
                var likeCount = parseInt(xhr.responseText);
                likeCountElement.textContent = likeCount;
            } else {
                // Handle error response if needed
            }
        };
        xhr.send('cardId=' + encodeURIComponent(cardId));
    }
}
</script>

<!-- Share function-->
<script>
// Selecting all elements with the class '.fa-share-nodes'
const shareIcons = document.querySelectorAll('.fa-share-nodes');

// Looping through each share icon and adding event listener
shareIcons.forEach(shareIcon => {
    shareIcon.addEventListener('click', function() {
        // Find the closest parent element with the class '.infos'
        const parentInfos = this.closest('.infos');
        
        // Find the 'a' tag within the parent element
        const recipeLink = parentInfos.querySelector('a.btn-details');

        // Checking if the 'a' tag is found
        if (recipeLink) {
            const recipeURL = recipeLink.href;
            if (navigator.share) {
                navigator.share({
                    title: document.title,
                    text: 'Check out this recipe!',
                    url: recipeURL
                })
                .then(() => console.log('Shared successfully'))
                .catch((error) => console.error('Error sharing:', error));
            } else {
                console.error('Sharing is not supported on this device');
            }
        } else {
            console.error('Recipe link not found');
        }
    });
});
</script>

<!--Redirect-->
<script>
    function filterCards(query) {
        const cards = document.querySelectorAll('.group');

        cards.forEach(card => {
            const cardTitle = card.querySelector('h2').textContent.toLowerCase();
            const cardContent = card.querySelector('p').textContent.toLowerCase();

            // Check if the card title or content contains the full word
            const matchFound = cardTitle.includes(query) || cardContent.includes(query);

            card.style.display = matchFound ? 'block' : 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchInput');
        const currentKeywords = new URLSearchParams(window.location.search).get('keywords');
        if (currentKeywords) {
            searchInput.value = currentKeywords;
            filterCards(currentKeywords.toLowerCase().trim()); // Filter cards based on current keywords
        }

        searchInput.addEventListener('input', function () {
            filterCards(searchInput.value.toLowerCase().trim());
        });

        function addSubmitEventListener() {
            const searchForm = document.getElementById('searchForm');
            if (searchForm) {
                searchForm.addEventListener('submit', function (event) {
                    event.preventDefault();
                    filterCards(searchInput.value.toLowerCase().trim());
                });
            } else {
                setTimeout(addSubmitEventListener, 100); // Retry after 100 milliseconds
            }
        }

        addSubmitEventListener();
    });
</script>


 <!--Button Scroll -->
<script>
 document.addEventListener('DOMContentLoaded', function() {
    // Get all scroll buttons
    var scrollButtons = document.querySelectorAll('.scroll-button');

    // Attach click event listener to each button
    scrollButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var targetId = this.getAttribute('data-target');
            var targetSection = document.getElementById(targetId);

            if (targetSection) {
                // Scroll to the target section
                targetSection.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });
});
</script>

<!--Comment function-->

<script>
    // Function to set the value of pageIdentifier
    function setPageIdentifier(identifier) {
        document.getElementById('pageIdentifier').value = identifier;
    }

    // Function to open the comment modal and set the pageIdentifier
    function openCommentModal(element, identifier) {
        // Set the value of pageIdentifier
        setPageIdentifier(identifier);
        // Open the comment modal
        // You need to implement this function (e.g., show the modal)
    }

    // Define the showCommentField function
    function showCommentField(posX, posY) {
        // Get the modal
        var modal = document.getElementById("commentModal");

        // Display the modal
        modal.style.display = "block";

        // Position the modal near the click position
        modal.style.left = (posX - 50) + "px"; // Adjust as needed
        modal.style.top = (posY + 10) + "px"; // Adjust as needed

        // Focus on the comment input field
        var commentInput = document.getElementById("commentInput");
        commentInput.focus();
    }

    // Get all elements with the class 'fa-regular.fa-comment'
    var commentIcons = document.querySelectorAll('.fa-regular.fa-comment');

    // Attach event listener to each comment icon
    commentIcons.forEach(function(commentIcon) {
        commentIcon.addEventListener('click', function(event) {
            var posX = event.clientX; // X-coordinate of the click event
            var posY = event.clientY; // Y-coordinate of the click event
            showCommentField(posX, posY); // Show the comment field modal near the click position
        });
    });

    // Define the showCommentModal function
    function showCommentModal(pageIdentifier) {
        // Get the modal
        var modal = document.getElementById("commentModal");

        // Set the action attribute of the comment form to the targeted PHP file
        var commentForm = document.getElementById("commentForm");
        commentForm.action = pageIdentifier + ".php";

        // Display the modal
        modal.style.display = "block";
    }

    // Define the hideCommentField function
    function hideCommentField() {
        // Get the modal
        var modal = document.getElementById("commentModal");

        // Hide the modal
        modal.style.display = "none";
    }
</script>


<?php include_once('footer.php');?>

</body>
</html>

