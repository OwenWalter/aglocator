$(document).ready(function() {  

$(".tablesearch").hide();

// Global variable to track current filter
var currentCategoryFilter = '';

console.log('triggers.js loaded successfully');

// Debug: Check if required elements exist
console.log('Filter button exists:', $('#filterBtn').length > 0);
console.log('Category filter dropdown exists:', $('#categoryFilter').length > 0);
console.log('Filter pill exists:', $('#filterPill').length > 0);
console.log('Category filter links count:', $('#categoryFilter a').length);

// Search
function search() {
	var query_value = $('input#name').val();
	console.log('Search called with query:', query_value, 'filter:', currentCategoryFilter);
	if(query_value !== ''){
		$.ajax({
			type: "POST",
			url: "php/search.php",
			data: { 
				query: query_value,
				category_filter: currentCategoryFilter
			},
			cache: false,
			success: function(html){
				console.log('Search successful, updating results');
				$("table#resultTable tbody").html(html);
			},
			error: function(xhr, status, error) {
				console.log('Search error:', error);
			}
		});
	}return false;    
}

// Update filter display
function updateFilterDisplay() {
	console.log('updateFilterDisplay called with filter:', currentCategoryFilter);
	if (currentCategoryFilter === '') {
		$("#filterPill").hide();
		$("#filterStatus").hide();
	} else {
		$("#filterPill").show().find('.filter-text').text(currentCategoryFilter);
		$("#filterStatus").show().find('#currentFilter').text(currentCategoryFilter);
	}
}

// Prevent dropdown from closing when clicking on filter items
$(document).on('click', '#categoryFilter', function(e) {
	e.stopPropagation();
	console.log('Dropdown container clicked');
});

// Handle filter dropdown selection
$(document).on('click', '#categoryFilter a', function(e) {
	e.preventDefault();
	e.stopPropagation();
	
	console.log('Filter dropdown clicked:', $(this).data('category'));
	
	var selectedCategory = $(this).data('category') || '';
	var categoryText = $(this).text();
	
	console.log('Selected category:', selectedCategory, 'Text:', categoryText);
	
	// Update current filter
	currentCategoryFilter = selectedCategory;
	
	// Update UI
	updateFilterDisplay();
	
	// Close the dropdown manually
	$('#filterBtn').dropdown('toggle');
	
	// Trigger search with current query if there is one
	var current_query = $('input#name').val();
	if (current_query !== '') {
		console.log('Triggering search with current query');
		search();
	}
	
	console.log('Filter set to:', currentCategoryFilter);
});

// Handle clear filter from pill
$(document).on('click', '#filterPill .close', function(e) {
	e.preventDefault();
	e.stopPropagation();
	console.log('Filter pill close clicked');
	
	// Reset filter
	currentCategoryFilter = '';
	updateFilterDisplay();
	
	// Trigger search with current query if there is one
	var current_query = $('input#name').val();
	if (current_query !== '') {
		search();
	}
});

// Handle clear filter link (backup)
$(document).on('click', '#clearFilter', function(e) {
	e.preventDefault();
	console.log('Clear filter link clicked');
	
	// Reset filter
	currentCategoryFilter = '';
	updateFilterDisplay();
	
	// Trigger search with current query if there is one
	var current_query = $('input#name').val();
	if (current_query !== '') {
		search();
	}
});

// Debug: Log when dropdown is shown/hidden
$('#filterBtn').on('shown.bs.dropdown', function () {
	console.log('Dropdown shown');
});

$('#filterBtn').on('hidden.bs.dropdown', function () {
	console.log('Dropdown hidden');
});

$("input#name").live("keyup", function(e) {
	// Set Timeout
	clearTimeout($.data(this, 'timer'));
	
	// Set Search String
	var search_string = $(this).val();
	
	// Do Search
	if (search_string == '') {
		$(".tablesearch").fadeOut(300);
	}else{
		$(".tablesearch").fadeIn(300);
		$(this).data('timer', setTimeout(search, 100));
	};
});

});