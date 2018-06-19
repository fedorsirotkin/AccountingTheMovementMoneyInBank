		<!-- ПОДВАЛ -->	
		<div id="footer">
		<p>	<?php echo $date . ' ' . $time; ?>
				<script language="javascript" type="text/javascript">
					//var d = new Date();			
					//var day = new Array("Воскресенье", "Понедельник", "Вторник", "Среда","Четверг","Пятница","Суббота");
					//var month = new Array("января", "февраля", "марта", "апреля", "мая", "июня", "июля", "августа", "сентября", "октября", "ноября", "декабря");
					//document.write(day[d.getDay()] + " " + d.getDate() + " " + month[d.getMonth()]
					//+ " " + d.getFullYear() + " г.");
				</script>				
		</p>
		<?php
			if (isset($_SESSION["login"]))
			   {
					echo '<p><a href="selectdate"><button type="button" class="btn btn-secondary btn-sm">Изменить дату</button></a></p>';  
			   }
		?>
		</div>
	</div>
	<script src="js/pikaday.js"></script>
	<script type="text/javascript">
		var picker = new Pikaday(
		{
			field: document.getElementById('datepicker'),
			firstDay: 1,
			minDate: new Date(1920, 0, 1),
			maxDate: new Date(2020, 12, 31),
			yearRange: [1920,2020]
		});
	</script>
	<script type="text/javascript">
        var startPicker = new Pikaday({
            field: document.getElementById('datepickertwo'),
            minDate: new Date(),
            maxDate: new Date(2040, 12, 31),
            onSelect: function() {
                startDate = this.getDate();
                updateStartDate();
            }
        })
	</script>		
	
	<script type="text/javascript">
		$('.only_numbers').keypress(function(e) {
			if (e.keyCode < 48 || e.keyCode > 57) {
				return false;
			}
		});
	</script>
	
    <script type="text/javascript">
            $(document).ready(function() {
                $("#datepicker").inputmask("y-m-d");			
				$("#input2").inputmask("d.m.y", { "placeholder": "*" });			
				$("#input3").inputmask("d.m.y", { "placeholder": "дд.мм.гггг" });			
				$("#input4").inputmask("d.m.y",{ 
					"oncomplete": function(){ alert('Ввод завершен'); }, 
					"onincomplete": function(){ alert('Заполнено не до конца'); },
					"oncleared": function(){ alert('Очищено'); }
				});		
				$("#input5").inputmask("d.m.y", { "clearIncomplete": true });			
				$("#input6").inputmask({ "mask": "9", "repeat": 10 });		
				$("#input7").inputmask({ "mask": "9", "repeat": 10, "greedy": false });			
				$("#input8").inputmask("d.m.y");				
				$('#input8-set').click(function() { $("#input8").val('21122012'); });			
				$('#input8-get').click(function() {	alert($("#input8").inputmask('unmaskedvalue')); });
				$("#input9").inputmask("+7(999)9999999");
				$.extend($.inputmask.defaults.aliases, {
					'non-negative-integer': {
						regex: {
							number: function (groupSeparator, groupSize) { return new RegExp("^(\\d*)$"); }
						},
						alias: "decimal"
					}
				});
				$("#input10").inputmask("non-negative-integer");

            });
     </script>
	 <script type="text/javascript">
		$(".closed").toggleClass("show");
		$(".title").click(function(){
		 $(this).parent().toggleClass("show").children("div.contents").slideToggle("medium");
		 if ($(this).parent().hasClass("show"))
			 $(this).children(".title_h3").css("background","#ffffff");
		 else $(this).children(".title_h3").css("background","#ffffff");
		});
	 </script>
	 
	 <script type="text/javascript">
		  jQuery(function($){
		  $("#contactphone").mask("+7(999) 999-99-99");
		  });
	</script>
	 
	<script type="text/javascript"> 
	function checkit()
	{
		var arrclientsid = [];
		var arrclientssurname = [];
		var arrclientsname = [];
		var arrclientspatronymic = [];
		var arrclientsfloor = [];
		var arrclientsbirthdate = [];
		var arrclientspassportdata = [];
		var arrclientsaddressdata = [];
		var arrclientscontactphone = []		
		<?php
			$query     = "SELECT * FROM `clients`";
			$query_run = mysql_query($query);
			$count_row = mysql_num_rows($query_run);
			if ($count_row > 0)
			{
				for ($i = 0; $i < $count_row; $i++)
				{
					$row = mysql_fetch_array($query_run);
					?>
						arrclientsid.push("<?php           echo $row["id"];           ?>");
						arrclientssurname.push("<?php      echo $row["surname"];      ?>");
						arrclientsname.push("<?php         echo $row["name"];         ?>");
						arrclientspatronymic.push("<?php   echo $row["patronymic"];   ?>");
						arrclientsfloor.push("<?php        echo $row["floor"];        ?>");
						arrclientsbirthdate.push("<?php    echo $row["birthdate"];    ?>");
						arrclientspassportdata.push("<?php echo $row["passportdata"]; ?>");
						arrclientsaddressdata.push("<?php  echo $row["addressdata"];  ?>");
						arrclientscontactphone.push("<?php echo $row["contactphone"]; ?>");							
					<?php
				}
			}
		?>
		var e = document.getElementById("getit");
		var strUser = e.options[e.selectedIndex].value;
		var input = document.getElementById('somethingfloor');
		input.value = arrclientsfloor[strUser - 1];
		var input = document.getElementById('somethingbirthdate');
		input.value = arrclientsbirthdate[strUser - 1];
		var input = document.getElementById('somethingpassportdata');
		input.value = arrclientspassportdata[strUser - 1];
		var input = document.getElementById('somethingaddressdata');
		input.value = arrclientsaddressdata[strUser - 1];
		var input = document.getElementById('somethingcontactphone');
		input.value = arrclientscontactphone[strUser - 1];
		return (strUser);
	}
	</script>
	
	<script type="text/javascript"> 
	function getsavingsaccount()
	{
		var arrsavingsaccountid = [];
		var arrsavingsaccountmoneytype = [];
		var arrsavingsaccountbalance = [];
		<?php
			$query     = "SELECT * FROM `savingsaccount`";
			$query_run = mysql_query($query);
			$count_row = mysql_num_rows($query_run);
			if ($count_row > 0)
			{
				for ($i = 0; $i < $count_row; $i++)
				{
					$row = mysql_fetch_array($query_run);
					?>
						arrsavingsaccountid.push("<?php        echo $row["id"];        ?>");
						arrsavingsaccountmoneytype.push("<?php echo $row["moneytype"]; ?>");
					<?php
				}
			}
		?>
		var e = document.getElementById("idsavingsaccount");
		var strUser = e.options[e.selectedIndex].value;
		var input = document.getElementById('somethingmoneytype');
		input.value = arrsavingsaccountmoneytype[strUser - 1];
		var input = document.getElementById('somethinidaccount');
		input.value = arrsavingsaccountid[strUser - 1];
	}
	</script>	
	
	<script type="text/javascript"> 
		$(document).ready(function() {	
			$("#idsavingsaccount").bind("change", function(event) {		
				$.ajax({
					url: "library/getbalance.php",
					type: "POST",
					data: ("moneyvalue=" + $("#idsavingsaccount").val()),
					dataType: "text",
					success: function(result) {
						$("#somethingbalance").next().remove();
						$("#somethingbalance").val(result);
					}
				});
			});
		});
	</script>
</body>
</html>