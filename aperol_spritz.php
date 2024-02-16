<?php
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

// Define the page identifier
$page_identifier = "aperol_spritz.php"; // Change this to match the identifier for your page

// Posting Comments
if ($_SERVER['REQUEST_METHOD'] == 'POST' && $logged_in) {
    // Process comment submission
    $comment = $_POST['comment'];
    if (!empty($comment)) {
        insert_comment($user_id, $comment, $page_identifier); // Pass the page identifier to insert_comment
        // Redirect to prevent form resubmission
        header("Location: aperol_spritz.php");
        exit;
    }
}

// Retrieving Comments
$result = get_comments($page_identifier); // Pass the page identifier to get_comments
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
font-family: "JosefinSans"
src: url("fontit/JosefinSans-Regular.ttf")

font-family: "JosefinSansBold"
src: url("fontit/JosefinSans-Bold.ttf")
}

h1{
    font-family: 'JosefinSans';
    letter-spacing: 2px;
}

h2{
    font-family: 'JosefinSans';
    letter-spacing: 1px;
}

p{
    font-family: 'JosefinSans';
    letter-spacing: 1px;
}

button{
    font-family: 'JosefinSans';
}

</style>
</head>

<?php include_once('header.php');?>  

<body class="bg-cover bg-no-repeat bg-center" style="background-image: url('img/mainbg.png')">

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mx-auto max-w-screen-xl mt-10 px-4 mb-12">
<img src="img/aperolspritz.jpg" class="rounded-lg object-cover" alt="" style="width: 608px; height: 455px;">
<div class="flex flex-col justify-between">
<div class="bottom-0">
        <h1 class="text-white text-3xl text-start mb-4 uppercase">Aperol Spritz</h1>
        <p class="text-white pb-10">With its distinct orange hue and refreshing bittersweet flavor, the Aperol Spritz adds a vibrant touch to every celebratory moment shared among friends. Its effervescent charm effortlessly complements the spontaneous gatherings, infusing them with nothing but positive energy and good vibes.</p>
        </div>
    
        <div class="flex list-none text-[#855200] justify-around text-center align-center items-center border bg-[#f9d342] py-10 rounded-lg">
            <div class="list-item">
                <i class="fa-solid fa-wine-bottle mb-4 text-3xl"></i>
                <h2 class="mb-3 text-2xl font-bold">Main spirit</h2>
                <p>Aperol, Prosecco</p>
            </div>
            <div class="list-item">
                <i class="fa-solid fa-face-smile mb-4 text-3xl"></i>
                <h2 class="mb-3 text-2xl font-bold">Flavor</h2>
                <p>Citrusy, bittersweet</p>
            </div>
            <div class="list-item">
                <i class="fa-solid fa-chart-simple mb-4 text-3xl"></i>
                <h2 class="mb-3 text-2xl font-bold">Skill level</h2>
                <p>Beginner</p>
            </div>
        </div>
</div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-8 mx-auto max-w-screen-xl px-4">
    <div>
<h1 class="text-white text-3xl uppercase mb-4">ingredients</h1>
            <p class="text-white pb-1">1½ parts Prosecco</p>
            <p class="text-white pb-1">1 part Aperol</p>
            <p class="text-white pb-1">½ part sode</p>
            <p class="text-white pb-1">Slice of orange</p>
            <p class="text-white pb-1"></p>
            <p class="text-white"></p>
        </div>
<div class="">
            <h1 class="text-white text-3xl text-start mb-4 uppercase">instructions</h1>
            <p class="text-white pb-5">
            Fill a large wine glass with ice. Pour Prosecco into the glass. Add Aperol to the mix. Top it off with a dash of soda. Garnish your drink with a slice of orange. Finally, enjoy this delightful cocktail with friends!</p>
        </div>
</div>


<section class="py-8 lg:py-16 antialiased">
    <div class="max-w-2xl mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-lg lg:text-2xl font-semibold text-white">Comments</h2> 
        </div>

<!-- Display Comments -->
<?php
// Loop through comments and display them
while ($comment = mysqli_fetch_assoc($result)) {
    echo '<article class="p-6 text-base bg-white rounded-lg mb-5">';
    echo '<footer class="flex justify-between items-center mb-6">';
    echo '<div class="flex items-center">';
    echo '<p class="inline-flex items-center mr-3 text-gray-900 dark:text-white font-semibold">';
    echo '<img class="mr-2 w-6 h-6 rounded-full" src="../tipsybartender/profileimg/' . $comment['profile_image'] . '" alt="' . $comment['username'] . '">' . $comment['username'] . '</p>';
    echo '<p class="text-sm text-gray-600 dark:text-gray-400"><time pubdate datetime="' . $comment['created_at'] . '" title="' . $comment['created_at'] . '">' . $comment['created_at'] . '</time></p>';
    echo '</div>';
    echo '</footer>';
    echo '<p class="text-gray-500 dark:text-gray-400">' . $comment['comment_text'] . '</p>';
    echo '</article>';
}
?>

            <!-- Post Comment Form -->
            <form class="mb-6" action="aperol_spritz.php" method="post">
                <div class="py-2 px-4 mb-4 bg-white rounded-lg rounded-t-lg border border-gray-200 dark:bg-gray-800 dark:border-gray-700">
                    <label for="comment" class="sr-only">Your comment</label>
                    <textarea id="comment" name="comment" rows="6" class="px-0 w-full text-sm text-gray-900 border-0 focus:ring-0 focus:outline-none dark:text-white dark:placeholder-gray-400 dark:bg-gray-800" placeholder="Write a comment..." required></textarea>
                </div>
                <div class="flex justify-between">
                    <button type="submit" class="inline-flex items-center py-2.5 px-4 font-semibold text-center text-[#292826] bg-[#f9d342] rounded-lg hover:bg-white">Comment</button>
                    <button id="showMoreComments" class="inline-flex items-center py-2.5 px-4 font-semibold text-center text-[#292826] bg-[#f9d342] rounded-lg hover:bg-white">Show more comments</button>
                </div>
            </form>
        </div>
    </section>


<?php include_once('footer.php');?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Hide all comments except the first five
        const comments = document.querySelectorAll('.max-w-2xl.mx-auto.px-4 article');
        for (let i = 5; i < comments.length; i++) {
            comments[i].style.display = 'none';
        }

        // Add click event listener to the "Show more comments" button
        const showMoreBtn = document.getElementById('showMoreComments');
        showMoreBtn.addEventListener('click', function() {
            for (let i = 5; i < comments.length; i++) {
                comments[i].style.display = 'block';
            }
            showMoreBtn.style.display = 'none'; // Hide the button after revealing all comments
        });
    });
</script>



</body>
</html>

