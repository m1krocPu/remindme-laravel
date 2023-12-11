<!DOCTYPE html>
<html lang="en">
	<head>
		<title>RemindMe</title>

		@vite('resources/css/app.css')
	</head>
	<body>
        <div id="main-wrapper">
				<div id="remindme-app">
					<router-view></router-view>
				</div>
		</div>
	</body>
	@vite('resources/js/app.js')
</html>
