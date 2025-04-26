<?php include '../../api/createPost.php'; 
include './components/flashMessage.php';
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="styles/index.css">
    <link rel="stylesheet" href="styles/createPost.css">
</head>
<body>

<div class="header-content">
    <?php include 'components/header.php'; ?>
</div>

<div class="body-container">
    <div class="sidebar-content">
        <?php include 'components/sidebar.php'; ?>
    </div>

    <div class="createPost-content">
        <div class="form-content">
            <h1>Create Post</h1>

            <!-- Category Card Selection -->
            <div class="card-selection">
                <div class="card" id="timber-card" onclick="showForm('timber')">Timber</div>
                <div class="card" id="lumber-card" onclick="showForm('lumber')">Lumber</div>
            </div>

            <!-- Timber Form -->
            <form id="timber-form" class="category-form" action="createPost.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="category" value="Timber">
                <div class="form-group">
                    <label for="type">Select Type:</label>
                    <select name="type" required>
                        <option value="Jak">Jak</option>
                        <option value="Teak">Teak</option>
                        <option value="Mahogani">Mahogani</option>
                        <option value="Nedum">Nedum</option>
                        <option value="Sooriyamaara">Sooriyamaara</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Diameter(mm):</label>
                    <input type="number" name="diameter" min="150" max="450" required>  
                </div>

                <div class="form-group">
                    <label>Quantity:</label>
                    <input type="number" name="quantity" min="1" required>
                    <label>Price per Unit:</label>
                    <input type="number" name="unitprice" min="1" required>
                </div>

                <div class="form-group">
                    <label>Additional Info:</label>
                    <textarea name="info"></textarea>
                </div>

                <div class="form-group">
                    <label>Upload Image:</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="button outline">Submit Timber Post</button>
                </div>
            </form>

            <!-- Lumber Form -->
            <form id="lumber-form" class="category-form" action="createPost.php" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="category" value="Lumber">
                <div class="form-group">
                    <label for="type">Select Type:</label>
                    <select name="type" required>
                    <option value="Jak">Jak</option>
                        <option value="Teak">Teak</option>
                        <option value="Mahogani">Mahogani</option>
                        <option value="Nedum">Nedum</option>
                        <option value="Sooriyamaara">Sooriyamaara</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Length(m):</label>
                    <input type="number" name="length" step="0.01" min="1" max="5" required>  
                    <label>Width(mm):</label>
                    <input type="number" name="width" min="50" max="150" required>
                    <label>Thickness(mm):</label>
                    <input type="number" name="thickness" min="12" max="50" required>
                </div>

                <div class="form-group">
                    <label>Quantity:</label>
                    <input type="number" name="quantity" min="1" required>
                    <label>Price per Unit:</label>
                    <input type="number" name="unitprice" min="1" required>
                </div>

                <div class="form-group">
                    <label>Additional Info:</label>
                    <textarea name="info"></textarea>
                </div>

                <div class="form-group">
                    <label>Upload Image:</label>
                    <input type="file" name="image" accept="image/*" required>
                </div>

                <div class="form-group">
                    <button type="submit" name="submit" class="button outline">Submit Lumber Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="scripts/createPost.js"></script>

</body>
</html>
