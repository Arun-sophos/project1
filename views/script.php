    <script>
        function search(query){
	var parameters = {
		q: $('#url').val();
	};
	$.ajax('')
	.done(function(data, textStatus, jqXHR){
		        
	})
	.fail(function(jqXHR, textStatus, errorThrown){
		//log error
                console.log(jqXHR);
	})
}
     </script>

