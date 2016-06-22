var categorySubCategoryButton = document.getElementById('categorySubCategoryButton');
if(categorySubCategoryButton){
	var categorySubCategoryDiv = document.getElementById('categorySubCategoryDiv');
	var blockTria = document.getElementById('block-tria');
	categorySubCategoryDiv.style.display = 'none';
	categorySubCategoryButton.addEventListener("click", function(){

		if(categorySubCategoryDiv.style.display == 'none'){
	categorySubCategoryDiv.style.display = 'block';
	blockTria.style.cssText = " border-bottom: 10px solid #616161; border-top:none; "
	}
	else{
			categorySubCategoryDiv.style.display = 'none';
			blockTria.style.cssText = " border-top: 10px solid #616161; border-bottom:none; "
	};
	})

}