<?php
$title = 'Youdemy - My Courses';
ob_start();
?>

<h1>My Courses</h1>

<?php if (empty($enrolledCourses)): ?>
    <p>You are not enrolled in any courses yet.</p>
<?php else: ?>
    <?php foreach ($enrolledCourses as $course): ?>
        <div style="border: 1px solid #ddd; padding: 10px; margin-bottom: 10px;">
            <h3><?php echo htmlspecialchars($course['title']); ?></h3>
            <p><?php echo htmlspecialchars(substr($course['description'], 0, 100)) . '...'; ?></p>
            <a href="index.php?action=course&id=<?php echo $course['id']; ?>" class="button">View Course</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php
$content = ob_get_clean();
include 'views/layout.php';
?>

