var d = new Date();
var month = new Array();
month[0] = "January";
month[1] = "February";
month[2] = "March";
month[3] = "April";
month[4] = "May";
month[5] = "June";
month[6] = "July";
month[7] = "August";
month[8] = "September";
month[9] = "October";
month[10] = "November";
month[11] = "December";
var pengurang = 1;
var bulan = month[moment().subtract(pengurang, 'months').format('MM')];
var bulanSekarang = moment().subtract(pengurang, 'months').format('MM');
var tahun = moment().subtract(pengurang, 'months').format('YYYY');
var dd = d.getDate();
var mm = d.getMonth()+1;
var yyyy = d.getFullYear();
if(dd<10) {
	dd='0'+dd
} 
if(mm<10) {
	mm='0'+mm
} 

var selectedDate = location.hash;
var selectyear = selectedDate.slice(1,5);
var selectDate, selectmodel, selectcat, selectareas, selectarea;
var selectmonth = selectedDate.substr(selectedDate.indexOf(".") + 1).replace("0", "");
			
var selectedCat = window.location.hash.substr(1);
var catParts = selectedCat.split("/");

if(catParts.length>0){
	selectareas = catParts[0];
	selectarea = catParts[0];
	selectcat = catParts[1];
	selectmodel = catParts[2];
	selectDate = catParts[3];
	if(selectarea=='Export'){
		selectarea = 'Export & ICS';
	}
}else{
	selectDate = selectedDate.replace("#", "");
}

function sidemenu(){
	$(".burger-menu").click(function (e) {
		if ($(this).hasClass("is-active")) {
			$(this).removeClass("is-active");
			$("#content").removeClass("slideMenu");
			$("#content").addClass("closeMenu");
		} else {
			$(this).addClass("is-active");
			$("#content").removeClass("closeMenu");
			$("#content").addClass("slideMenu");
		}
	});
}
function tabsub(){
	$('a[href="#tab-click"]').click(function (e) {
		e.preventDefault();
		var r = $(this).attr('rel');
		if (r == 'page1') {
			$('#page1').removeClass('hidden');
			$('#page2').addClass('hidden');
			$('#tab-page1').addClass('act_tb');
			$('#tab-page2').removeClass('act_tb');
		} else if (r == 'page2') {
			$('#page1').addClass('hidden');
			$('#page2').removeClass('hidden');
			$('#tab-page1').removeClass('act_tb');
			$('#tab-page2').addClass('act_tb');
		}
	});
}

function tabpage(){
	$('a[href="#tab-page"]').click(function (e) {
		e.preventDefault();
		var r = $(this).attr('rel');
		if (r == 'data-sp') {
			window.location.href = 'p2_fin_sp_pc_chart.html#'+selectDate;
		} else if (r == 'data-sg') {
			window.location.href = 'p2_fin_sg_pc_chart.html#'+selectDate;
		} else if (r == 'data-st') {
			window.location.href = 'p2_fin_st_pc_chart.html#'+selectDate;
		} else if (r == 'data-tl') {
			window.location.href = 'p2_fin_tlcc_pc_chart.html#'+selectDate;
		} else if (r == 'data-smi') {
			$('#tab-smi').removeClass('img_foot2');
			window.location.href = 'p2_fin_smi_pc_chart.html#'+selectDate;
		}
	});
	
	$('a[href="#tab-page2"]').click(function (e) {
		e.preventDefault();
		var r = $(this).attr('rel');
		if (r == 'data-sp') {
			window.location.href = 'p2_fin_sp_pc_chart2.html#'+selectDate;
		} else if (r == 'data-sg') {
			window.location.href = 'p2_fin_sg_pc_chart2.html#'+selectDate;
		} else if (r == 'data-st') {
			window.location.href = 'p2_fin_st_pc_chart2.html#'+selectDate;
		} else if (r == 'data-tl') {
			window.location.href = 'p2_fin_tlcc_pc_chart2.html#'+selectDate;
		} else if (r == 'data-smi') {
			$('#tab-smi').removeClass('img_foot2');
			window.location.href = 'p2_fin_smi_pc_chart2.html#'+selectDate;
		}
	});
}
