<?php

class ResultController extends BaseController {

	public function getSearchResults() {

		if (Session::has('pattern')) {
			$pattern = Session::get('pattern');
			Cache::put('pattern', $pattern, 60*24);
		} elseif (Cache::has('pattern')) {
			echo "Retrieved pattern from cache!\n";
			$pattern = Cache::get('pattern');
		} else {
			return Redirect::route('pattern');
		}

		if (Session::has('results')) {
			$results = Session::get('results');
			Cache::put('results', $results, 60*24);
		} elseif (Cache::has('results')) {
			echo "Retrieved results from cache!\n";
			$results = Cache::get('results');
		} else {
			return Redirect::route('pattern');
		}

		return View::make('results.list');
	}


	public function getResultDetail($id) {

		// echo "<br><br><br><br><br><br>";

		if (Cache::has('results') && Cache::has('pattern')) {

			$results = Cache::get('results');
			foreach ($results as $item) {
				if ($item->file_id == $id) {
					$result = $item;
				}
			}

			$pattern = Cache::get('pattern');

			$upload = Upload::find($id);

			// var_dump($results);


			$xml = simplexml_load_file($upload->url);
			// getting extracts with start, end and measures between
			for ($i = 0; $i < count($result->occurences); $i++) {
				$resultExtracts[$i] = array();

				$start = $result->occurences[$i]->start;
				$end = $result->occurences[$i]->end;
				$voice = $result->occurences[$i]->voice;
				$part_id = $result->occurences[$i]->part_id;

				$startMeasure = $xml->xpath('//part[@id="' . $part_id . '"]//note[' . $start . ']/..');
				// $startMeasure = $xml->xpath('//note[' . $start . ']/..');
				$startMeasureNumber = (int)$startMeasure[0]['number'];
				$endMeasure = $xml->xpath('//part[@id="' . $part_id . '"]//note[' . $end . ']/..');
				// $endMeasure = $xml->xpath('//note[' . $end . ']/..');
				$endMeasureNumber = (int)$endMeasure[0]['number'];
				for ($j = $startMeasureNumber; $j <= $endMeasureNumber; $j++) {
					// echo $i . " | " . $j;
					// echo "<br>";
					$resultExtracts[$i][] = $xml->xpath('//part[@id="' . $part_id . '"]/measure[@number="' . $j . '"]');
				}
			}

			// echo "<pre>";
			// // var_dump($endMeasure);
			// var_dump($resultExtracts);
			// echo "</pre>";
			// echo "<hr>";

			return View::make('results.detail')
						->with('resultExtracts', $resultExtracts);
		} else {
			Redirect::route('pattern');
		}
	}


	public static function _getArtist($id) {
		$xml = simplexml_load_file(Upload::find($id)->url);
		$artist = $xml->xpath("//credit[credit-type='composer']");
		// var_dump($artist[0]);
		if ($artist) {
			return $artist[0]->{'credit-words'}->{0};
		} else {
			return "Unknown";
		}
	}
	public static function _getTitle($id) {
		$xml = simplexml_load_file(Upload::find($id)->url);
		$title = $xml->xpath("//credit[credit-type='title']");
		// var_dump($title[0]->{'credit-words'});
		if ($title) {
			return $title[0]->{'credit-words'}->{0};
		} else {
			return "Unknown";
		}
	}
}