/**
 * Highcharts Drilldown plugin
 * 
 * Author: Torstein Honsi
 * Last revision: 2013-02-18
 * License: MIT License
 *
 * Demo: http://jsfiddle.net/highcharts/Vf3yT/
 */

/*global HighchartsAdapter*/
(function (H) {

	"use strict";

	var noop = function () {},
		defaultOptions = H.getOptions(),
		each = H.each,
		extend = H.extend,
		wrap = H.wrap,
		Chart = H.Chart,
		seriesTypes = H.seriesTypes,
		PieSeries = seriesTypes.pie,
		ColumnSeries = seriesTypes.column,
		fireEvent = HighchartsAdapter.fireEvent;

	// Utilities
	function tweenColors(startColor, endColor, pos) {
		var rgba = [
				Math.round(startColor[0] + (endColor[0] - startColor[0]) * pos),
				Math.round(startColor[1] + (endColor[1] - startColor[1]) * pos),
				Math.round(startColor[2] + (endColor[2] - startColor[2]) * pos),
				startColor[3] + (endColor[3] - startColor[3]) * pos
			];
		return 'rgba(' + rgba.join(',') + ')';
	}

	// Add language
	extend(defaultOptions.lang, {
		drillUpText: '