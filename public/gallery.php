<?php include './includes/header.php'; ?>
    <main>
        <h2>Images of Japan</h2>
      <p id="picCount">Displaying 1 to 6 of 8</p>
        <div id="gallery">
            <table id="thumbs">
                <tr>
					<!--This row needs to be repeated-->
                    <td><a href="gallery.php"><img src="images/thumbs/basin.jpg" alt="" width="80" height="54"></a></td>
                </tr>
				<!-- Navigation link needs to go here -->
            </table>
            <figure id="main_image">
                <img src="images/basin.jpg" alt="" width="350" height="237">
                <figcaption>Water basin at Ryoanji temple, Kyoto</figcaption>
            </figure>
        </div>
    </main>
    <?php include './includes/footer.php'; ?>