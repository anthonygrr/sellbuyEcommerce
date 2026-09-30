<?php 

session_start();

    ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://code.jquery.com/jquery-3.3.1.js"></script>
  <!-- Favicon -->
  <link rel="shortcut icon" href="/images/hnet.com-image.ico" type="image/x-icon" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
  

  <!-- Custom StyleSheet -->
  <link rel="stylesheet" href="/css/styles.css" />
  <title>Products</title>
</head>

<body>

  <!-- Navigation -->
  
  <?php include __DIR__ . "/../../backend/layouts/_nav.php"?>

  <!-- PRODUCTS -->

  <section class="section products">
 
    <div class="products-layout container">

      <div class="col-1-of-4">
        <div>
          <div class="block-title">
            <h3>Category</h3>
          </div>

          <ul class="block-content">
            <li>
              <input type="radio" name="category_list" value="1" id="category_all" onclick="checkCategory()">
              <label for="category_all">
                <span>All</span>
                <small>(10)</small>
              </label>
            </li>

            <li>
              <input type="radio" name="category_list" value="2" id="category_bags"  onclick="checkCategory()">
              <label for="category_bags">
                <span>Bags</span>
                <small>(7)</small>
              </label>
            </li>
            
            <li>
              <input type="radio" name="category_list"  value="3" id="category_accesories"  onclick="checkCategory()">
              <label for="category_accesories">
                <span> Accessories</span>
                <small>(3)</small>
              </label>
            </li>

            <li>
              <input type="radio" name="category_list" id="category_shirts" value="4" onclick="checkCategory()">
              <label for="category_shirts">
                <span>Clothings</span>
                <small>(3)</small>
              </label>
            </li>

            <li>
              <input type="radio" name="category_list" id="category_shoes" value="5" onclick="checkCategory()">
              <label for="category_shoes">
                <span>Shoes</span>
                <small>(3)</small>
              </label>
            </li>
          </ul>
        </div>

        <!-- BRANDS -->
        <!-- <div>
          <div class="block-title">
            <h3>Brands</h3>
          </div>

          <ul class="block-content">
            <li>
              <input type="radio" name="" id="">
              <label for="">
                <span>Gucci</span>
                <small>(10)</small>
              </label>
            </li>

            <li>
              <input type="checkbox" name="" id="">
              <label for="">
                <span>Burberry</span>
                <small>(7)</small>
              </label>
            </li>

            <li>
              <input type="checkbox" name="" id="">
              <label for="">
                <span> Accessories</span>
                <small>(3)</small>
              </label>
            </li>

            <li>
              <input type="checkbox" name="" id="">
              <label for="">
                <span>Valentino</span>
                <small>(3)</small>
              </label>
            </li>

            <li>
              <input type="checkbox" name="" id="">
              <label for="">
                <span>Dolce & Gabbana</span>
                <small>(3)</small>
              </label>
            </li>

            <li>
              <input type="checkbox" name="" id="">
              <label for="">
                <span>Hogan</span>
                <small>(3)</small>
              </label>
            </li>

            <li>
              <input type="checkbox" name="" id="">
              <label for="">
                <span>Moreschi</span>
                <small>(3)</small>
              </label>
            </li>

            <li>
              <input type="checkbox" name="" id="">
              <label for="">
                <span>Givenchy</span>
                <small>(3)</small>
              </label>
            </li>
          </ul>
        </div> -->

      </div>
      <div class="col-3-of-4">
        <form action="">

          <div class="item">
            <label for="sort-by">Sort By</label>
            <select name="sort-by" id="sort-by">
              <option value="title" selected="selected">Name</option>
              <option value="number">Price</option>
              <option value="search_api_relevance">Relevance</option>
              <option value="created">Newness</option>
            </select>
          </div>

          <div class="item">
            <label for="order-by">Order</label>
            <select name="order-by" id="sort-by">
              <option value="ASC" selected="selected">ASC</option>
              <option value="DESC">DESC</option>
            </select>
          </div>
          <a href="">Apply</a>
        </form>

        <div class="product-layout" id="product_area">

          <!-- <div class="product">
            <div class="img-container">
              <a href="productDetails.html">
              <img src="/images/products/product1.jpg" alt="" />
            </a>
              <div class="addCart">
                <i class="fas fa-shopping-cart"></i>
              </div>

              <ul class="side-icons">
                <span><i class="fas fa-search"></i></span>
                <span><i class="far fa-heart"></i></span>
                <span><i class="fas fa-sliders-h"></i></span>
              </ul>
            </div>
            <div class="bottom">
              <a href="productDetails.html">Bambi Print Mini Backpack</a>
              <div class="price">
                <span>$150</span>
              </div>
            </div>
          </div> -->


        </div>

        <!-- PAGINATION (container only; filled by renderPagination()) -->
        <ul class="pagination"></ul>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include __DIR__ . "/../../backend/layouts/_footer.php"?>
  <!-- End Footer -->

  <!-- Custom Scripts -->
  <script src="/js/dark.js"></script>
  <script src="/js/products.js"></script>
  <script src="/js/slider.js"></script>
  <script src="/js/index.js"></script>
  <script  type="text/javascript" src="/js/search.js"></script>

  <script type="text/javascript">
    // --- Catalog state (T4: real pagination) ---
    let currentCharge = 1;
    let currentPage = 1;
    let totalPages = 1;
    const PER_PAGE = 12;

    $(document).ready(function () {
      loadProducts();
    });

    // Single product-card template (previously duplicated across six ajax blocks).
    function buildProductCard(p) {
      return (
        '<div class="product">' +
        '<div class="img-container">' +
        '<a href="/pages/catalog/productDetails.php?p=' + p.code_prod + '"><img src="/images/products/' + p.image_route + '" alt="" /></a>' +
        '<div class="addCart">' +
        ' <a href="/pages/catalog/productDetails.php?p=' + p.code_prod + '"><i class="fas fa-shopping-cart"></i></a>' +
        '</div>' +
        '<ul class="side-icons">' +
        '<span><i class="fas fa-search"></i></span>' +
        '<span><i class="far fa-heart"></i></span>' +
        '<span><i class="fas fa-sliders-h"></i></span>' +
        '</ul>' +
        '</div>' +
        '<div class="bottom">' +
        '<a href="/pages/catalog/productDetails.php?p=' + p.code_prod + '">' + p.name_prod + '</a>' +
        '<div class="price">' +
        '<span>$' + p.price_prod + '</span>' +
        '</div>' +
        '</div>' +
        '</div>'
      );
    }

    // Single loader: fetches one page of products and repaints grid + pagination.
    function loadProducts() {
      $.ajax({
        url: '/backend/product/get_all_products.php',
        type: 'POST',
        data: {
          charge: currentCharge,
          page: currentPage,
          per_page: PER_PAGE
        },
        success: function (data) {
          var datos = data && data.datos ? data.datos : [];
          var area = document.getElementById('product_area');

          if (datos.length === 0) {
            area.innerHTML = '<p class="no-products">No products found.</p>';
          } else {
            var html = '';
            for (var i = 0; i < datos.length; i++) {
              html += buildProductCard(datos[i]);
            }
            area.innerHTML = html;
          }

          totalPages = parseInt(data && data.total_pages, 10) || 1;
          currentPage = parseInt(data && data.page, 10) || 1;
          renderPagination(totalPages, currentPage);
        },
        error: function (err) {
          console.error(err);
          var area = document.getElementById('product_area');
          if (area) {
            area.innerHTML = '<p class="no-products">Could not load products. Please try again.</p>';
          }
        }
      });
    }

    // Builds: prev | number window (with ellipsis gaps) | tail (… + Last ») | next.
    function renderPagination(pages, page) {
      var $ul = $('.pagination');
      $ul.empty();

      pages = parseInt(pages, 10);
      page = parseInt(page, 10);
      if (isNaN(pages) || pages <= 1) {
        return;
      }
      if (isNaN(page) || page < 1) {
        page = 1;
      }
      if (page > pages) {
        page = pages;
      }

      var html = '';

      if (page === 1) {
        html += '<span class="prev disabled" aria-hidden="true">‹</span>';
      } else {
        html += '<span class="prev" data-page="' + (page - 1) + '" title="Previous page">‹</span>';
      }

      // Visible numbers: always {1} plus {current-2 .. current+2}, each
      // clamped to [1, pages] and kept sorted-unique.
      var visible = [1];
      for (var v = page - 2; v <= page + 2; v++) {
        if (v >= 1 && v <= pages && visible.indexOf(v) === -1) {
          visible.push(v);
        }
      }
      visible.sort(function (a, b) {
        return a - b;
      });

      // Walk the set; a gap > 1 between consecutive numbers inserts an ellipsis.
      var lastN = 0;
      for (var i = 0; i < visible.length; i++) {
        var n = visible[i];
        if (n - lastN > 1) {
          html += '<span class="icon" aria-hidden="true">…</span>';
        }
        if (n === page) {
          html += '<span class="active" data-page="' + n + '" title="Page ' + n + ' (current)">' + n + '</span>';
        } else {
          html += '<span data-page="' + n + '" title="Go to page ' + n + '">' + n + '</span>';
        }
        lastN = n;
      }

      // Tail handling: lastN = highest emitted number.
      //   lastN === pages        -> nothing more
      //   lastN + 1 === pages    -> append the final page as a normal number
      //   otherwise (tail hidden)-> ellipsis, then the "Last »" pill
      if (lastN < pages) {
        if (lastN + 1 === pages) {
          html += '<span data-page="' + pages + '" title="Go to page ' + pages + '">' + pages + '</span>';
        } else {
          html += '<span class="icon" aria-hidden="true">…</span>';
          html += '<span class="last" data-page="' + pages + '" title="Last page">Last »</span>';
        }
      }

      if (page === pages) {
        html += '<span class="next disabled" aria-hidden="true">›</span>';
      } else {
        html += '<span class="next" data-page="' + (page + 1) + '" title="Next page">›</span>';
      }

      $ul.html(html);
    }

    // One delegated handler for every pagination control.
    $('.pagination').on('click', 'span[data-page]', function () {
      var target = parseInt($(this).data('page'), 10);
      if (isNaN(target) || target < 1 || target > totalPages || target === currentPage) {
        return;
      }
      currentPage = target;
      loadProducts();

      var layout = document.querySelector('.products-layout');
      if (layout) {
        layout.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });

    // Radio values verified in markup: all=1, bags=2, accesories=3, shirts=4, shoes=5.
    function checkCategory() {
      var checked = document.querySelector('input[name="category_list"]:checked');
      if (!checked) {
        return;
      }
      var charge = parseInt(checked.value, 10);
      if (isNaN(charge)) {
        return;
      }
      currentCharge = charge;
      currentPage = 1;
      loadProducts();
    }




</script>




    
    





</body>

</html>