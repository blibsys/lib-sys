<nav>
  <?php $nav_courses = find_all_courses(); ?>
  <ul class="courses">
    <?php while($nav_course = mysqli_fetch_assoc($nav_courses)) { ?>
      <li>
        <a href="<?php echo url_for('index.php'); ?>">
          <?php echo h($nav_course['menu_name']); ?>
    </a>
      </li>
    <?php } // while $nav_courses ?>
  </ul>
  <?php mysqli_free_result($nav_courses); ?>
</nav>
