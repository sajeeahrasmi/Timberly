<?php include '../../api/createPost.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="/Supplier/styles/index.css">
    <link rel="stylesheet" href="/Supplier/styles/createPost.css">
    <style>
        .card-selection {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            flex: 1;
            padding: 40px;
            background-color: #f1f1f1;
            text-align: center;
            border: 2px solid transparent;
            border-radius: 12px;
            cursor: pointer;
            transition: 0.3s;
            font-size: 1.5rem;
            font-weight: bold;
            color:#895D47; 
        }

        .card:hover {
            background-color: #B18068;
            border-color: #999;
            color: #fff;
            

        }

        .card.active {
            border-color: #B18068;
            background-color: #B18068;
            color : #fff;
        }

        .category-form {
            display: none;
        }

        .category-form.active {
            display: block;
        }
    </style>
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
                    </select>
                </div>

                <div class="form-group">
                    <label>Diameter(mm):</label>
                    <input type="number" name="diameter" min="0" required>
                    <label>Quantity:</label>
                    <input type="number" name="quantity" min="0" required>
                </div>

                <div class="form-group">
                    <label>Price:</label>
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
                        <option value="Mahogani">Mahogani</option>
                        <option value="Cinamond">Cinamond</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Length(m):</label>
                    <input type="number" name="length" min="0" required>
                    <label>Width(mm):</label>
                    <input type="number" name="width" min="0" required>
                    <label>Thickness(mm):</label>
                    <input type="number" name="thickness" min="0" required>
                </div>

                <div class="form-group">
                    <label>Quantity:</label>
                    <input type="number" name="quantity" min="1" required>
                    <label>Price per Unit(LKR):</label>
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

<script>
function showForm(category) {
    const timberCard = document.getElementById('timber-card');
    const lumberCard = document.getElementById('lumber-card');
    const timberForm = document.getElementById('timber-form');
    const lumberForm = document.getElementById('lumber-form');

    if (category === 'timber') {
        timberCard.classList.add('active');
        lumberCard.classList.remove('active');
        timberForm.classList.add('active');
        lumberForm.classList.remove('active');
    } else if (category === 'lumber') {
        lumberCard.classList.add('active');
        timberCard.classList.remove('active');
        lumberForm.classList.add('active');
        timberForm.classList.remove('active');
    }
}
</script>

</body>
</html>
