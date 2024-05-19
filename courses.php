<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Courses - Matt Jerry's Education Hub</title>
    <link rel="stylesheet" href="CSS.css">
</head>
<body>
    <header>
        <h1>Courses</h1>
        <nav>
            <ul>
                <li><a href="homepage.php">Home</a></li>
                <li><a href="courses.php" class="active">Courses</a></li>
                <li><a href="about.html">About Me</a></li>
                <li><a href="tutorials.html">Video Tutorials</a></li>
                <li><a href="sign-up.php">Sign Up</a></li>
                <li><a href="sign-in.php">Sign In</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="programming-courses">
            <h2>Programming Language Courses</h2>
            <!-- Python Programming -->
            <div class="course-section">
                <h3>Python Programming - $399</h3>
                <p>Master Python from the basics to advanced data manipulation and analysis techniques.</p>
                <form action="checkout.php" method="get">
                    <input type="hidden" name="courseName" value="Python Programming">
                    <input type="hidden" name="price" value="399">
                    <button type="submit" style="width:100%;">Purchase Python</button>
                </form>
            </div>
            
            <!-- Web Development -->
            <div class="course-section">
                <h3>Web Development - $499</h3>
                <p>Comprehensive course covering front-end and back-end development skills.</p>
                <form action="checkout.php" method="get">
                    <input type="hidden" name="courseName" value="Web Development">
                    <input type="hidden" name="price" value="499">
                    <button type="submit" style="width:100%;">Purchase Web Dev</button>
                </form>
            </div>
            
            <!-- Advanced Programming Languages -->
            <div class="course-section">
                <h3>Advanced Programming Languages - $599</h3>
                <p>Deep dive into back-end development and system programming with Java and C++.</p>
                <form action="checkout.php" method="get">
                    <input type="hidden" name="courseName" value="Advanced Programming Languages">
                    <input type="hidden" name="price" value="599">
                    <button type="submit" style="width:100%;">Purchase Advanced</button>
                </form>
            </div>
            
            <!-- Bundle Discount Offer -->
            <div class="course-bundle">
                <h3>Bundle Offer: All Programming Courses - $1299</h3>
                <p>Purchase all three courses in a bundle and save $198!</p>
                <form action="checkout.php" method="get">
                    <input type="hidden" name="courseName" value="All Programming Courses Bundle">
                    <input type="hidden" name="price" value="1299">
                    <button type="submit" style="width:100%;">Purchase Bundle</button>
                </form>
            </div>
        </section>

        <section id="mathematics-courses">
            <h2>Mathematics Courses</h2>
            <!-- Linear Algebra -->
            <div class="course-section">
                <h3>Linear Algebra - $249</h3>
                <p>Explore vector spaces, linear transformations, eigenvalues, and eigenvectors.</p>
                <form action="checkout.php" method="get">
                    <input type="hidden" name="courseName" value="Linear Algebra">
                    <input type="hidden" name="price" value="249">
                    <button type="submit" style="width:100%;">Purchase Linear Algebra</button>
                </form>
            </div>
        
            <!-- Calculus I, II, III, and IV -->
            <div class="course-section">
                <h3>Calculus Series - $349</h3>
                <p>Master everything from limits and derivatives to integral calculus and series.</p>
                <form action="checkout.php" method="get">
                    <input type="hidden" name="courseName" value="Calculus Series">
                    <input type="hidden" name="price" value="349">
                    <button type="submit" style="width:100%;">Purchase Calculus Series</button>
                </form>
            </div>
        
            <!-- Ordinary Differential Equations -->
            <div class="course-section">
                <h3>Ordinary Differential Equations - $199</h3>
                <p>Learn to solve differential equations that model real-world phenomena.</p>
                <form action="checkout.php" method="get">
                    <input type="hidden" name="courseName" value="Ordinary Differential Equations">
                    <input type="hidden" name="price" value="199">
                    <button type="submit" style="width:100%;">Purchase ODEs</button>
                </form>
            </div>
        
            <!-- Partial Differential Equations -->
            <div class="course-section">
                <h3>Partial Differential Equations - $299</h3>
                <p>Understand the techniques to solve PDEs, crucial for modeling multi-variable systems.</p>
                <form action="checkout.php" method="get">
                    <input type="hidden" name="courseName" value="Partial Differential Equations">
                    <input type="hidden" name="price" value="299">
                    <button type="submit" style="width:100%;">Purchase PDEs</button>
                </form>
            </div>
        
            <!-- Bundle Discount Offer -->
            <div class="course-bundle">
                <h3>Complete Mathematics Package - $899</h3>
                <p>Purchase all mathematics courses in a bundle and save $197!</p>
                <form action="checkout.php" method="get">
                    <input type="hidden" name="courseName" value="Complete Mathematics Package">
                    <input type="hidden" name="price" value="899">
                    <button type="submit" style="width:100%;">Purchase Math Package</button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p><a href="copyright.html">Copyright © 2024 Matt Jerry</a></p>
        <p><a href="terms.html">Terms Of Service<a/></p>
        <p><a href="privacypolicy.html">Privacy Policy</a></p>
    </footer>

    <script src="Javascript.js"></script>
</body>
</html>
