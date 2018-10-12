<nav class="navbar navbar-expand-md sticky-top" id="navbar">
    <div class="">
      <button class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
        <span class="fa fa-bars" aria-hidden="true"></span>
      </button>
    <div class="collapse navbar-collapse" id="collapse_target">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="no-underline nav-link" href="index.php">Homepage</a></li>
        <li class="dropdown"><a class="no-underline dropdown-toggle nav-link" data-hover="dropdown" href="" data-toggle="dropdown">Category</a>
          <ul class="dropdown-menu">
            <?php 
              $categories  = mysqli_fetch_all(mysqli_query($conn, "SELECT * from categories"),MYSQLI_ASSOC);
              foreach ($categories as $category) {
                $category_id = $category["id"];
                $category_name=$category["category"];
                echo "<li class='dropdown-item'><a class='no-underline nav-link' href='category.php?cate_id= $category_id'>$category_name</a></li>";
              }
             ?>
          
          </ul>
        </li>
        <li class="dropdown"><a class="no-underline dropdown-toggle nav-link" data-hover="dropdown" href="" data-toggle="dropdown">Top Branches</a>
          <ul class="dropdown-menu">
            <?php 
              $branches  = mysqli_fetch_all(mysqli_query($conn,  "SELECT `branch_id`, COUNT(`branch_id`) AS `value_occurrence` FROM `products` GROUP BY `branch_id` ORDER BY `value_occurrence` DESC LIMIT 10"),MYSQLI_ASSOC);
              foreach ($branches as $branch) {
                $branch_id = $branch["branch_id"];
                $branch_names = mysqli_fetch_assoc(mysqli_query($conn,  "select branch from product_branch where id = $branch_id "));
                $branch_name = $branch_names["branch"];
                echo "<li class='dropdown-item'><a class='no-underline nav-link' href='category.php?branch_id= $branch_id'>$branch_name</a></li>";
              }
             ?>
          
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
