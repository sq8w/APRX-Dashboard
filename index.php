<?php
$aprs = file("/tmp/aprx-rf.log");
rsort($aprs);
foreach ($aprs as $single) :
	$single = explode(" ", $single);

	if ($single[6] === 'T' && $single[2] === "SR8WXL") :
		$tx++;
	endif;
	if ($single[6] === 'R' && $single[2] === "SR8WXL") :
		$rx++;
	endif;
endforeach;
?>
<!DOCTYPE html>
<html lang="pl" data-bs-theme="dark">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>APRX Dashboard by SQ8W</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>

<div class="container">
	<div class="row gy-1 gy-sm-3 mt-3 mt-sm-5 justify-content-center">
		<div class="col-12">
			<h1 class="text-center p-1 p-sm-3 h2">APRX Dashboard <small class="text-body-secondary" style="font-size: 0.6rem;">by <a class="link-warning link-underline-dark link-underline-opacity-0" style="text-decoration: none;" href="https://www.qrz.com/db/sq8w" target="_blank">SQ8W</a></small></h1>
		</div>
	</div>
	<div class="row gy-3 mt-3 mt-sm-5 gy-sm-5 justify-content-center text-center text-sm-start">
		<div class="col-12 col-md-5 col-lg-4 col-xl-3">
			<p class="h3 m-0 p-0">👋 Siema!</p>
			<p class="fs-6 mt-3">Dashboard pokazuje wszystkie nadane oraz odebrane pakiety APRS.</p>
			<p class="fs-6 mt-3">Klikając na znak stacji zostaniesz przeniesiony do mapy.</p>
		</div>
		<div class="offset-md-1 col-12 col-md-6 col-lg-7 col-xl-8">
			<div class="row gy-1 gy-sm-4">
				<div class="col-12">
					<h3 class="h4 mb-5 mb-sm-3 flex-column flex-sm-row d-flex justify-content-center justify-content-sm-start align-items-center gap-3"><span class="badge text-bg-warning fs-5">SR8WXL</span> <small class="text-body-secondary" style="font-size: 0.6rem;">Przepuszcza stacje w obrębie 10km z ikonami /[ oraz />.</small></h3>
				</div>
				<div class="col-12 col-xl-6">
					<h2 class="h5 mb-3 text-center text-sm-start">Nadane: <span class="badge text-bg-warning fs-5"><?php echo $tx; ?></span> pakiety</h2>
					<div class="row d-none d-sm-flex">
						<div class="col-5 text-body-secondary">
							Znak
						</div>
						<div class="col-6 text-body-secondary">
							Ostatnio nadany
						</div>
					</div>

				<?php $stationCounts = [];

				// Liczenie wystąpień stacji
				foreach ($aprs as $single) :
					$single = explode(" ", $single);

					if ($single[6] === 'T' && $single[2] === "SR8WXL") :
						$station = explode(">", $single[7])[0];
						// Zwiększ licznik wystąpień stacji
						if (!isset($stationCounts[$station])):
							$stationCounts[$station] = 1;
						else:
							$stationCounts[$station]++;
						endif;
					endif;
				endforeach;

				// Wyświetlanie unikalnych stacji
				$displayedStations = [];

				foreach ($aprs as $single) :
				$single = explode(" ", $single);

				if ($single[6] === 'T' && $single[2] === "SR8WXL") :
					$station = explode(">", $single[7])[0];

					// Sprawdź, czy liczba wystąpień stacji wynosi więcej niż 1
					if ($stationCounts[$station] >= 1 && !in_array($station, $displayedStations)) :
						$displayedStations[] = $station; ?>
						
					<div class="row text-center text-sm-start mb-3 mb-sm-0">
						<div class="col-12 col-sm-5">
							<span>
								<a target="_blank" class="link-warning link-underline-dark link-underline-opacity-0" href="https://aprs.fi/#!call=a%2F<?php echo $station; ?>&timerange=3600&tail=3600">
									<?php echo $station; ?>
								</a>
								(<?php echo $stationCounts[$station]; ?>)
							</span>
						</div>
						<div class="col-12 col-sm-7">
							<span><?php echo convertUtcToLocal($single[0] . ' ' . $single[1]); ?></span>
						</div>
					</div>
				<?php endif; endif; endforeach; ?>
				</div>
				<div class="col-12 col-xl-6">
					<h2 class="h5 mb-3 text-center text-sm-start">Odebrane: <span class="badge text-bg-warning fs-5"><?php echo $rx; ?></span> pakiety</h2>
					<div class="row d-none d-sm-flex">
						<div class="col-5 text-body-secondary">
							Znak
						</div>
						<div class="col-7 text-body-secondary">
							Ostatnio odebrany
						</div>
					</div>
					<?php $stationCounts = [];

					// Liczenie wystąpień stacji
					foreach ($aprs as $single) :
						$single = explode(" ", $single);

						if ($single[6] === 'R' && $single[2] === "SR8WXL") :
							$station = explode(">", $single[7])[0];

							// Zwiększ licznik wystąpień stacji
							if (!isset($stationCounts[$station])):
								$stationCounts[$station] = 1;
							else:
								$stationCounts[$station]++;
							endif;
						endif;
					endforeach;

					// Wyświetlanie unikalnych stacji
					$displayedStations = [];

					foreach ($aprs as $single) :
					$single = explode(" ", $single);

					if ($single[6] === 'R' && $single[2] === "SR8WXL") :
						$station = explode(">", $single[7])[0];

						// Sprawdź, czy liczba wystąpień stacji wynosi więcej niż 1
						if ($stationCounts[$station] >= 1 && !in_array($station, $displayedStations)) :
							$displayedStations[] = $station; ?>
							
						<div class="row text-center text-sm-start mb-3 mb-sm-0">
							<div class="col-12 col-sm-5">
								<span>
									<a target="_blank" class="link-warning link-underline-dark link-underline-opacity-0" href="https://aprs.fi/#!call=a%2F<?php echo $station; ?>&timerange=3600&tail=3600">
										<?php echo $station; ?>
									</a>
									(<?php echo $stationCounts[$station]; ?>)
								</span>
							</div>
							<div class="col-12 col-sm-7">
								<span><?php echo convertUtcToLocal($single[0] . ' ' . $single[1]); ?></span>
							</div>
						</div>
					<?php endif; endif; endforeach; ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-5 mb-5">
		<div class="col-12">
			<p style="font-size: 0.5rem" class="text-center">Chcesz wesprzeć moje projekty?</p>
			<a href="https://buycoffee.to/wojtekjakiela" target="_blank" class="d-block text-center mb-3 link-underline-opacity-0"><img src="https://buycoffee.to/btn/buycoffeeto-btn-primary.svg" style="width: 150px" alt="Postaw mi kawę na buycoffee.to"></a>
			<p style="font-size: 0.5rem" class="text-center"><strong>APRX Dashboard</strong> stworzony i utrzymywany przez <a class="link-warning link-underline-dark link-underline-opacity-0" href="https://wojtekjakiela.pl">Wojtek Jakieła / SQ8W</a>. Wszelkie prawa zastrzeżone.</p>
		</div>
	</div>
</div>


<?php function convertUtcToLocal($utcTime) {
    // Utwórz obiekt DateTime dla czasu UTC
    $utcDateTime = new DateTime($utcTime, new DateTimeZone('UTC'));

    // Ustaw strefę czasową na lokalną
    $utcDateTime->setTimezone(new DateTimeZone('Europe/Warsaw'));

    // Zwróć sformatowany czas lokalny
    return $utcDateTime->format('d.m.Y \o H:i');
} ?>
</body>
</html>
