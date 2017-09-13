<div class="search-form-container">
  <form role="search" method="get" class="search-form" action="<?php echo esc_url(get_site_url('/')); ?>">
    <fieldset class="search-box">

  		<label>
        <span class="screen-reader-text">Search:</span>
      </label>

  		<input type="search" class="search-field" placeholder="Search.." value="" name="s" required />

      <div class="submit-button">
  		    <button type="submit" class="search-submit">
            <i class="icon-search"></i>
          </button>
      </div>
    </fieldset>
  </form>
</div>
