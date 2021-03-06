<div class="box box-info">
	<div class="box-header with-border">
		<h3 class="box-title">Add Map</h3>
		<div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			</button>
		</div>
	</div>
	<!-- /.box-header -->
	<!-- form start -->
	<form id="map_post-form" action="./map_upload" method="POST"
				class="form-horizontal" enctype="multipart/form-data">
		<div class="box-body">
			<div class="form-group">
				<label for="inputPassword3" class="col-sm-2 control-label">Zip File</label>

				<div class="col-sm-10">
					<div style="position: relative;">
						<input type="hidden" name="MAX_FILE_SIZE" value="1073741824"/>
						<input id="mapfile" type="file" class="form-control"
									 name="userfile" accept="application/zip,.gz" style="position: absolute;" required/>
						<div class="input-group" style="position: absolute;">
							<input type="text" id="map_photoCover"
										 class="form-control readonly"
										 placeholder="file name"
										 disabled>
							<span class="input-group-btn">
                  <button
										type="button" class="btn btn-info"
										onclick="$('input[id=mapfile]').click();">Browse
                  </button>
                </span>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label for="mapName" class="col-sm-2 control-label">Auto configuration</label>
				<div class="col-sm-10">
					<label class="radio-inline">
						<input type="radio" onchange="updateConfigs()" id="autoconfig" name="autoconfig" value="1" checked>TRUE
					</label>
					<label class="radio-inline">
						<input type="radio" onchange="updateConfigs()" name="autoconfig" value="0">FALSE
					</label>
				</div>
			</div>

			<div class="form-group">
				<label for="mapName" class="col-sm-2 control-label">Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control" name="map_name"
								 id="mapName"
								 placeholder="map name"
								 required disabled>
				</div>
			</div>
		</div>
		<!-- /.box-body -->
		<div class="box-footer">
			<!-- <button type="submit" class="btn btn-default">キャンセル</button> -->
			<button type="submit" class="btn btn-info pull-right">Add</button>
		</div>
		<!-- /.box-footer -->
		<input type="hidden" name="action" value="create">
	</form>
	<div id="map_post-form-overlay" class="overlay" style="display: none;">
		<i class="fa fa-refresh fa-spin"></i>
	</div>
</div>
<!-- /.box -->

<script>

	$(".readonly").keydown(function (e) {
		e.preventDefault();
	});

	var updateConfigs = function () {
		if (document.getElementById("autoconfig").checked) {
			document.getElementById("mapName").value = "";
			document.getElementById("mapName").disabled = true;
		} else {
			if (document.getElementById("mapName").value == '') {
				try {
					var name = $("#mapfile").prop('files')[0].name;
					name = name.replace(/\.(zip|tar\.gz)$/, '', 'i');
					document.getElementById("mapName").value = name;
				} catch (e) {}
			}
			document.getElementById("mapName").disabled = false;
		}
	}

	$('input[id=mapfile]').change(function () {
		$('#map_photoCover').val($(this).prop('files')[0].name);
		updateConfigs();
	});

	$("#map_post-form").submit(function (e) {

		$('#map_post-form-overlay').show();
		e.preventDefault();
		var form = document.querySelector('#map_post-form');
		fetch('./map_upload', {
			method: 'POST', credentials: "include",
			body: new FormData(form)
		})
			.then(function (response) {
				return response.json()
			})
			.then(function (json) {
				console.log(json);
				$('#map_post-form-overlay').hide();
				if (json["result"] == "success") {
					//toastr.success(json["title"],"Success");
					//var form = document.querySelector('#post-form');
					//$(form).find("textarea, :text, select").val("").end().find(":checked").prop("checked", false);
				}
				console.log(json);

				if (json['status']) {
					toastr["success"](
						"Add Map",
						"Success");
					document.querySelector('#map_post-form').reset();
				} else {
					toastr["error"](
						"Add Map",
						"Error");
				}
				dispatchAddMapEvent();
			});


	});

	function dispatchAddMapEvent() {
		var customEvent = document.createEvent("HTMLEvents");
		customEvent.initEvent("adf_add_map", true, false);
		//fire
		document.dispatchEvent(customEvent);
	}
</script>
