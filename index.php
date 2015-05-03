<html>
	<head>
		<title>PHP Interview Test</title>
                <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>
	<body>
		<h1>PHP Test</h1>
		<p>This test's purpose is to demonstrate the understanding and relationship between HTML, Javascript, PHP and HTTP.  
		There are 3 files associated with this test, index.php, request.php, and people.csv.  The index.php will serve as the 
		as the front end webpage that will be opened in the web browser.  Upon loading, it will send an AJAX to the request.php
		and get all of the people from the csv.  It should load them into the table of index.php.  Buttons on the webpage should 
		allow the user to sort the table.  Sorting can be done either server side or client side in javascript.</p>

		<h3>Instructions</h3>
		<ol>
			<li>Parse csv with PHP in request.php</li>
			<li>Create object structure using classes, people and person.</li>
			<li>Create method in which takes these objects from the previous step and return them via HTTP</li>
			<li>Use Jquery to request the return from the previous step</li>
			<li>Now these objects are in Java script, fill the HTML with the results</li>
			<li>Add sorting functionality to buttons, serverside or clientside(hint: think this through before choosing)</li>
		</ol>
		<h3>HTML Table</h3>
		<button id='name' class='asc'>Sort by last name</button>
		<button id='height' class='asc'>Sort by height</button>
                <button id="gender" class='asc'>Sort by gender</button>
		<button id='birthday' class='asc'>Sort by birthdate</button>
		<BR><BR>
		<table border="1" id="dtable">
			<tr>
				<th>Name</th>
				<th>Height</th>
				<th>Gender</th>
				<th>Birthdate</th>
			</tr>
                        
		</table>
<!--        
If you need pagination, and don't want to download the entire data to the client, 
then you must perform the sorting on the server (otherwise the client can only sort the rows it currently has,
which will lead to wrong results, if you re-sort by a different column).  
Sorting on the server is faster (as in: you can sort more rows/second), 
but if you have to serve 10000 clients at once, this may easily invert.
There is a greatjQuery plugin DataTable for this purpose.

For our case we choose to do the sorting by javascript because When sorting on the client, you can re-sort without downloading the data again.
-->
                
            <script>  
                    $(function(){
                        //set all of the records to be displayed a global variable
                        var dataset;
                        
                        //ajax call to fetch data from the csv and display the records
                        $.get("request.php", function( data ) {
                                var data = JSON.parse(data);
                                dataset = data;
                                var l=data.length;
                                var i;
                                for(i=0; i<l; i++){
                                       $('#dtable tr:last').after('<tr><td>'+data[i].name+'</td><td>'+data[i].height+'</td><td>'+data[i].gender+'</td><td>'+data[i].birthday+'</td></tr>');
                                }
                        });
    
                        $("button").on('click', function(){
                                var sort_field = $(this).attr('id');  
                                var order = $(this).attr('class');   
                                var sorted = sortByKey(dataset, sort_field, order);   console.log(sorted);
                                $('#dtable').find("tr:gt(0)").remove();
                                var i;
                                var l=sorted.length;
                                for(i=0; i<l; i++){
                                    $('#dtable tr:last').after('<tr><td>'+sorted[i].name+'</td><td>'+sorted[i].height+'</td><td>'+sorted[i].gender+'</td><td>'+sorted[i].birthday+'</td></tr>');
                                }        
                                if(order === 'asc'){
                                    $(this).attr("class","desc");
                                }
                                else{
                                    $(this).attr("class","asc");
                                }    
                        });

                        //sort function
                        function sortByKey(array, key, order) {
                                return array.sort(function(a, b) {
                                    switch (key) {
                                        case 'name':
                                            var x = a[key].split(" ").pop(); 
                                            var y = b[key].split(" ").pop();
                                            break;
                                        case 'height':
                                            var x = Number(a[key]); 
                                            var y = Number(b[key]);
                                            break;
                                        case 'birthday':
                                            //the format makes it impossible to know if a record like 3/2/04 is born in 1904 or 2004!!!!
                                            var x = new Date (a[key].split('/')[2],a[key].split('/')[0],a[key].split('/')[1]);  
                                            var y = new Date (b[key].split('/')[2],b[key].split('/')[0],b[key].split('/')[1]);
                                            break;
                                        default:
                                            var x = a[key];   
                                            var y = b[key];
                                        } 
        
                                        if(order ==='asc'){
                                            return ((x < y) ? -1 : ((x > y) ? 1 : 0));
                                        }
                                        else{
                                            return ((x < y) ? 1 : ((x > y) ? -1 : 0));
                                        }
                                });
                        }

                    })
            </script>
	</body>
</html>


    