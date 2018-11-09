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

var bulan = month[d.getMonth()];
var blnTemp = '0'+ (d.getMonth() + 1);
var bulanSekarang = blnTemp.substr(-2);
var tahun = d.getFullYear();

var paradigma = {
	bulanNow: function(type = null){
		if (type == 'str') {
			return month[d.getMonth()];
		}else {
			var blnTemp = '0'+ (d.getMonth() + 1);
			return blnTemp.substr(-2);

		}
		return false;
	},
	tahunNow: function(){
		return d.getFullYear();
	},
	date: function(par1 = null, par2 = null, par3 = null){

		// DOCUMENTATION
		// ================================================================
		// console.log('paradigma date -> current => '+paradigma.date());
	 //    console.log('paradigma date -> current => '+paradigma.date('now'));
	 //    console.log('paradigma date -> last => '+paradigma.date('last'));

	 //    console.log('paradigma -> current => day '+paradigma.date('now', 'day'));
	 //    console.log('paradigma -> current => month '+paradigma.date('now', 'month'));
	 //    console.log('paradigma -> current => year '+paradigma.date('now', 'year'));

	 //    console.log('paradigma -> last => '+paradigma.date('last', 'day'));
	 //    console.log('paradigma -> last => '+paradigma.date('last', 'month'));
	 //    console.log('paradigma -> last => '+paradigma.date('last', 'year'));
	 // =============================================================================
	 //  var parDate = paradigma.date('now', 'month');
                // console.log("parDate======================================");
                // console.log(parDate);
                //  var parDate = paradigma.date('now', 'month', 'YYYY-MM-DD');
                // console.log("parDate======================================");
                // console.log(parDate);
                //  var parDate = paradigma.date('prev', 'month');
                // console.log("parDate======================================");
                // console.log(parDate);
                //  var parDate = paradigma.date('prev', 'month', 'YYYY-MM-DD');
                // console.log("parDate======================================");
                // console.log(parDate);

		if (par1 == null || par1 == 'now') {
			if (par2==null) {
				return moment().format((par3!=null)?par3:'DD-MM-YYYY');
			}else if (par2=='month') {
				return moment().format((par3!=null)?par3:'MM');
			}else if (par2=='day') {
				return moment().format((par3!=null)?par3:'DD');
			}else if (par2=='year') {
				return moment().format((par3!=null)?par3:'YYYY');
			}

			return false;
		}else if (par1 == 'prev' || par1 == 'last' ) {
			if (par2==null) {
				return moment(moment().add(-1, 'days')).format((par3!=null)?par3:'DD-MM-YYYY');
			}else if (par2=='month') {
				return moment(moment().add(-1, 'months')).format((par3!=null)?par3:'MM');
			}else if (par2=='day') {
				return moment(moment().add(-1, 'days')).format((par3!=null)?par3:'DD');
			}else if (par2=='year') {
				return moment(moment().add(-1, 'years')).format((par3!=null)?par3:'YYYY');
			}

			return false;
		}

		return false;
		
	},

	array_sort: function(sortArray, sortOrder = 'asc', sortBy) {
		if (sortBy) {
			sortArray.sort(
				function(a, b) {
					if (sortOrder == 'desc' || sortOrder == 'DESC') {
						return b[sortBy] - a[sortBy]
					} else if (sortOrder == 'asc' || sortOrder == 'ASC') {
						return a[sortBy] - b[sortBy]
					}
				}

			);
			return true;
		} else {
			sortArray.sort(
				function(a, b) {
					if (sortOrder == 'desc' || sortOrder == 'DESC') {
						return b - a
					} else if (sortOrder == 'asc' || sortOrder == 'ASC') {
						return a - b
					}
				}

			);
			return true;
		}

		return false;

	},
	json_parse: function(json, tag = null){
		var datajson;
		if (json || tag) {
			try {
					dataJson = JSON.parse(json);
                	// paradigma.jsonOnNull(dataJson, tag_target);
					if (dataJson.length==0) {
						stop_waitMe(tag);
						// alert('Sorry !!\ndata is empty, please choose another month.');
						return false;
			        }else{
			        	return dataJson;
			        }


             }catch(e){
             	// console.log(e);
             	// alert('Sorry !!\ndata is empty, please choose another month.\nor back to previous menu');
             	stop_waitMe(tag);
             	return false;
             }
			
		}
		// stop_waitMe(tag);
		return false;
		
	}
}