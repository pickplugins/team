
const { Component, RawHTML, useState, useEffect } = wp.element;
import { RichText } from '@wordpress/block-editor'

import { Icon, close, settings, cloud, plus, post } from "@wordpress/icons";
import { ReactSortable } from "react-sortablejs";
import {
	PanelBody,
	RangeControl,
	Button,
	ButtonGroup,
	Panel,
	PanelRow,
	Dropdown,
	DropdownMenu,
	SelectControl,
	ColorPicker,
	ColorPalette,
	ToolsPanelItem,
	ComboboxControl,
	Spinner,
	ToggleControl,
	CustomSelectControl,
	Popover,
	__experimentalInputControl as InputControl,
} from "@wordpress/components";
import apiFetch from "@wordpress/api-fetch";
import { Splide, SplideTrack } from "@splidejs/react-splide";

import PGDropdown from '../../components/dropdown'


var myStore = wp.data.select("postgrid-shop");

function Html(props) {

	if (!props.warn) {
		return null;
	}



	var onChange = props.onChange;

	var [postData, setpostData] = useState(props.postData); // Using the hook.
	var [teamData, setteamData] = useState(postData.post_content); // Using the hook.

	var [styleObj, setstyleObj] = useState({}); // Using the hook.

	var [globalOptions, setglobalOptions] = useState(teamData.globalOptions); // Using the hook.




	useEffect(() => {
		setpostData(props.postData)

	}, [props.postData]);


	useEffect(() => {

		setteamData(postData.post_content)

	}, [postData]);






	var blockClass = "#team-" + postData.ID;



	var wrapperSelector = blockClass + "";
	var itemsWrapSelector = blockClass + " .items";
	var itemWrapSelector = blockClass + " .item";

	var paginationWrapSelector = blockClass + " .pagination";
	var paginationItemSelector = blockClass + " .pagination .item";
	var paginationItemActiveSelector = blockClass + " .pagination .item.current";

	var navsWrapSelector = blockClass + " .navs-wrapper";



	if (globalOptions.viewType == "teamSlider") {
		var itemsWrapSelector = blockClass + " .splide__track";
		var nextSelector = blockClass + " .splide__arrow--next";
		var prevSelector = blockClass + " .splide__arrow--prev";
		var nextIconSelector = blockClass + " .splide__arrow--next .icon";
		var prevIconSelector = blockClass + " .splide__arrow--prev .icon";
		var navsWrapSelector = blockClass + " .splide__arrows";
		var navItemSelector = blockClass + " .splide__arrow";

		var paginationWrapSelector = blockClass + " .splide__pagination";
		var paginationItemSelector = blockClass + " .splide__pagination__page";
		var paginationItemActiveSelector = blockClass + " .splide__pagination__page.is-active";
	}


	function getElementSelector(sudoScource, mainSelector) {
		var elementSelector = mainSelector;
		if (sudoScource == "styles") {
			elementSelector = mainSelector;
		} else if (sudoScource == "hover") {
			elementSelector = mainSelector + ":hover";
		} else if (sudoScource == "after") {
			elementSelector = mainSelector + "::after";
		} else if (sudoScource == "before") {
			elementSelector = mainSelector + "::before";
		} else if (sudoScource == "first-child") {
			elementSelector = mainSelector + ":first-child";
		} else if (sudoScource == "last-child") {
			elementSelector = mainSelector + ":last-child";
		} else if (sudoScource == "visited") {
			elementSelector = mainSelector + ":visited";
		} else if (sudoScource == "selection") {
			elementSelector = mainSelector + "::selection";
		} else if (sudoScource == "first-letter") {
			elementSelector = mainSelector + "::first-letter";
		} else if (sudoScource == "first-line") {
			elementSelector = mainSelector + "::first-line";
		} else {
			elementSelector = mainSelector + ":" + sudoScource;
		}
		return elementSelector;
	}
	function cssAttrParse(key) {
		var cssProp = "";
		if (key == "alignContent") {
			cssProp = "align-content";
		} else if (key == "alignItems") {
			cssProp = "align-items";
		} else if (key == "animationName") {
			cssProp = "animation-name";
		} else if (key == "alignSelf") {
			cssProp = "align-self";
		} else if (key == "aspectRatio") {
			cssProp = "aspect-ratio";
		} else if (key == "backfaceVisibility") {
			cssProp = "backface-visibility";
		} else if (key == "backgroundAttachment") {
			cssProp = "background-attachment";
		} else if (key == "backgroundBlendMode") {
			cssProp = "background-blend-mode";
		} else if (key == "backgroundClip") {
			cssProp = "background-clip";
		} else if (key == "bgColor") {
			cssProp = "background-color";
		} else if (key == "backgroundColor") {
			cssProp = "background-color";
		} else if (key == "backgroundOrigin") {
			cssProp = "background-origin";
		} else if (key == "backgroundRepeat") {
			cssProp = "background-repeat";
		} else if (key == "backgroundSize") {
			cssProp = "background-size";
		} else if (key == "backgroundPosition") {
			cssProp = "background-position";
		} else if (key == "backgroundImage") {
			cssProp = "background-image";
		} else if (key == "border") {
			cssProp = "border";
		} else if (key == "borderTop") {
			cssProp = "border-top";
		} else if (key == "borderRight") {
			cssProp = "border-right";
		} else if (key == "borderBottom") {
			cssProp = "border-bottom";
		} else if (key == "borderLeft") {
			cssProp = "border-left";
		} else if (key == "borderRadius") {
			cssProp = "border-radius";
		} else if (key == "borderCollapse") {
			cssProp = "border-collapse";
		} else if (key == "borderSpacing") {
			cssProp = "border-spacing";
		} else if (key == "borderImage") {
			cssProp = "border-image";
		} else if (key == "boxShadow") {
			cssProp = "box-shadow";
		} else if (key == "backdropFilter") {
			cssProp = "backdrop-filter";
		} else if (
			key == "bottom" ||
			key == "top" ||
			key == "left" ||
			key == "right" ||
			key == "clear" ||
			key == "color" ||
			key == "filter" ||
			key == "float"
		) {
			cssProp = key;
		} else if (key == "boxSizing") {
			cssProp = "box-sizing";
		} else if (key == "cursor") {
			cssProp = "cursor";
		} else if (key == "content") {
			cssProp = "content";
		} else if (key == "counterIncrement") {
			cssProp = "counter-increment";
		} else if (key == "counterReset") {
			cssProp = "counter-reset";
		} else if (key == "counterSet") {
			cssProp = "counter-set";
		} else if (key == "columnCount") {
			cssProp = "column-count";
		} else if (key == "columnRule") {
			cssProp = "column-rule";
		} else if (key == "direction") {
			cssProp = "direction";
		} else if (key == "fontFamily") {
			cssProp = "font-family";
		} else if (key == "fontSize") {
			cssProp = "font-size";
		} else if (key == "fontStyle") {
			cssProp = "font-style";
		} else if (key == "fontStretch") {
			cssProp = "font-stretch";
		} else if (key == "fontWeight") {
			cssProp = "font-weight";
		} else if (key == "fontVariantCaps") {
			cssProp = "font-variant-caps";
		} else if (key == "flexWrap") {
			cssProp = "flex-wrap";
		} else if (key == "flexDirection") {
			cssProp = "flex-direction";
		} else if (key == "flexGrow") {
			cssProp = "flex-grow";
		} else if (key == "flexShrink") {
			cssProp = "flex-shrink";
		} else if (key == "flexBasis") {
			cssProp = "flex-basis";
		} else if (key == "flexFlow") {
			cssProp = "flex-flow";
		} else if (key == "letterSpacing") {
			cssProp = "letter-spacing";
		} else if (key == "gridAutoFlow") {
			cssProp = "grid-auto-flow";
		} else if (key == "gridColumnEnd") {
			cssProp = "grid-column-end";
		} else if (key == "gridColumnStart") {
			cssProp = "grid-column-start";
		} else if (key == "gridRowEnd") {
			cssProp = "grid-row-end";
		} else if (key == "gridRowStart") {
			cssProp = "grid-row-start";
		} else if (key == "gridTemplateColumns") {
			cssProp = "grid-template-columns";
		} else if (key == "gridTemplateRows") {
			cssProp = "grid-template-rows";
		} else if (key == "listStyle") {
			cssProp = "list-style";
		} else if (key == "lineHeight") {
			cssProp = "line-height";
		} else if (key == "justifyContent") {
			cssProp = "justify-content";
		} else if (key == "maskImage") {
			cssProp = "mask-image";
		} else if (key == "objectFit") {
			cssProp = "object-fit";
		} else if (key == "opacity") {
			cssProp = "opacity";
		} else if (key == "outline") {
			cssProp = "outline";
		} else if (key == "order") {
			cssProp = "order";
		} else if (key == "outlineOffset") {
			cssProp = "outline-offset";
		} else if (key == "position") {
			cssProp = "position";
		} else if (key == "textIndent") {
			cssProp = "text-indent";
		} else if (key == "textJustify") {
			cssProp = "text-justify";
		} else if (key == "textTransform") {
			cssProp = "text-transform";
		} else if (key == "textDecoration") {
			cssProp = "text-decoration";
		} else if (key == "textOverflow") {
			cssProp = "text-overflow";
		} else if (key == "textShadow") {
			cssProp = "text-shadow";
		} else if (key == "textAlign") {
			cssProp = "text-align";
		} else if (key == "visibility") {
			cssProp = "visibility";
		} else if (key == "wordBreak") {
			cssProp = "word-break";
		} else if (key == "wordSpacing") {
			cssProp = "word-spacing";
		} else if (key == "zIndex") {
			cssProp = "z-index";
		} else if (key == "padding") {
			cssProp = "padding";
		} else if (key == "paddingTop") {
			cssProp = "padding-top";
		} else if (key == "paddingRight") {
			cssProp = "padding-right";
		} else if (key == "paddingBottom") {
			cssProp = "padding-bottom";
		} else if (key == "paddingLeft") {
			cssProp = "padding-left";
		} else if (key == "placeItems") {
			cssProp = "place-items";
		} else if (key == "margin") {
			cssProp = "margin";
		} else if (key == "marginTop") {
			cssProp = "margin-top";
		} else if (key == "marginRight") {
			cssProp = "margin-right";
		} else if (key == "marginBottom") {
			cssProp = "margin-bottom";
		} else if (key == "marginLeft") {
			cssProp = "margin-left";
		} else if (key == "display") {
			cssProp = "display";
		} else if (key == "width") {
			cssProp = "width";
		} else if (key == "height") {
			cssProp = "height";
		} else if (key == "verticalAlign") {
			cssProp = "vertical-align";
		} else if (key == "overflow") {
			cssProp = "overflow";
		} else if (key == "overflowX") {
			cssProp = "overflow-x";
		} else if (key == "overflowY") {
			cssProp = "overflow-y";
		} else if (key == "writingMode") {
			cssProp = "writing-mode";
		} else if (key == "wordWrap") {
			cssProp = "word-wrap";
		} else if (key == "perspective") {
			cssProp = "perspective";
		} else if (key == "minWidth") {
			cssProp = "min-width";
		} else if (key == "minHeight") {
			cssProp = "min-height";
		} else if (key == "maxHeight") {
			cssProp = "max-height";
		} else if (key == "maxWidth") {
			cssProp = "max-width";
		} else if (key == "transition") {
			cssProp = "transition";
		} else if (key == "transform") {
			cssProp = "transform";
		} else if (key == "transformOrigin") {
			cssProp = "transform-origin";
		} else if (key == "transformStyle") {
			cssProp = "transform-style";
		} else if (key == "tableLayout") {
			cssProp = "table-layout";
		} else if (key == "emptyCells") {
			cssProp = "empty-cells";
		} else if (key == "captionSide") {
			cssProp = "caption-side";
		} else if (key == "gap") {
			cssProp = "gap";
		} else if (key == "rowGap") {
			cssProp = "row-gap";
		} else if (key == "columnGap") {
			cssProp = "column-gap";
		} else if (key == "userSelect") {
			cssProp = "user-select";
		} else if (key == "-webkit-text-fill-color") {
			cssProp = "-webkit-text-fill-color";
		} else {
			cssProp = key;
		}
		return cssProp;
	}

	function generateElementCss(obj, elementSelector) {
		if (obj == null) {
			return {};
		}

		var cssObj = {};

		Object.entries(obj).map((args) => {
			var sudoSrc = args[0];
			var sudoArgs = args[1];
			if (sudoSrc != "options" && sudoArgs != null) {
				var selector = getElementSelector(sudoSrc, elementSelector);
				Object.entries(args[1]).map((x) => {
					var attr = x[0];
					var propVal = x[1];
					var cssPropty = cssAttrParse(attr);
					var found = Object.entries(propVal).reduce(
						(a, [k, v]) => (v ? ((a[k] = v), a) : a),
						{}
					);

					if (Object.keys(found).length > 0) {
						if (cssObj[selector] == undefined) {
							cssObj[selector] = {};
						}
						if (cssObj[selector][cssPropty] == undefined) {
							cssObj[selector][cssPropty] = {};
						}

						cssObj[selector][cssPropty] = x[1];
					}
				});
			}
		});

		return cssObj;
	}

	function generateBlockCss(items) {
		var reponsiveCssGroups = {};
		for (var selector in items) {
			var attrs = items[selector];
			for (var attr in attrs) {
				var breakpoints = attrs[attr];
				for (var device in breakpoints) {
					var attrValue = breakpoints[device];
					if (reponsiveCssGroups[device] == undefined) {
						reponsiveCssGroups[device] = [];
					}
					if (reponsiveCssGroups[device] == undefined) {
						reponsiveCssGroups[device] = [];
					}
					if (reponsiveCssGroups[device][selector] == undefined) {
						reponsiveCssGroups[device][selector] = [];
					}
					if (typeof attrValue == "string") {
						attrValue = attrValue.replaceAll("u0022", '"');
						reponsiveCssGroups[device][selector].push({
							attr: attr,
							val: attrValue,
						});
					}
				}
			}
		}
		var reponsiveCssDesktop = "";
		if (reponsiveCssGroups["Desktop"] != undefined) {
			for (var selector in reponsiveCssGroups["Desktop"]) {
				var attrs = reponsiveCssGroups["Desktop"][selector];
				reponsiveCssDesktop += selector + "{";
				for (var index in attrs) {
					var attr = attrs[index];
					var attrName = attr.attr;
					var attrValue = attr.val;
					reponsiveCssDesktop += attrName + ":" + attrValue + ";";
				}
				reponsiveCssDesktop += "}";
			}
		}
		var reponsiveCssTablet = "";
		if (reponsiveCssGroups["Tablet"] != undefined) {
			reponsiveCssTablet += "@media(max-width: 991px){";
			for (var selector in reponsiveCssGroups["Tablet"]) {
				var attrs = reponsiveCssGroups["Tablet"][selector];
				reponsiveCssTablet += selector + "{";
				for (var index in attrs) {
					var attr = attrs[index];
					var attrName = attr.attr;
					var attrValue = attr.val;
					reponsiveCssTablet += attrName + ":" + attrValue + ";";
				}
				reponsiveCssTablet += "}";
			}
			reponsiveCssTablet += "}";
		}
		var reponsiveCssMobile = "";
		if (reponsiveCssGroups["Mobile"] != undefined) {
			reponsiveCssMobile += "@media(max-width:767px){";
			for (var selector in reponsiveCssGroups["Mobile"]) {
				var attrs = reponsiveCssGroups["Mobile"][selector];
				reponsiveCssMobile += selector + "{";
				for (var index in attrs) {
					var attr = attrs[index];
					var attrName = attr.attr;
					var attrValue = attr.val;
					reponsiveCssMobile += attrName + ":" + attrValue + ";";
				}
				reponsiveCssMobile += "}";
			}
			reponsiveCssMobile += "}";
		}
		var reponsiveCss =
			reponsiveCssDesktop + reponsiveCssTablet + reponsiveCssMobile;

		return reponsiveCss;


	}

	useEffect(() => {
		var reponsiveCss = generateBlockCss(styleObj);

		onChange(reponsiveCss)

		var wpfooter = document.getElementById("wpfooter");
		var csswrappg = document.getElementById("css-block");

		if (csswrappg == null) {
			var divWrap = '<style id="css-block">' + reponsiveCss + '</style>';
			wpfooter.insertAdjacentHTML("beforeend", divWrap);
			var csswrappg = document.getElementById("css-block");
			csswrappg.innerHtml = reponsiveCss;

		} else {
			csswrappg.innerHTML = reponsiveCss;
		}


	}, [styleObj]);

	function flattenObject(input) {
		let flatArray = [];

		function recursiveFlatten(obj) {
			// Push the current object without its children
			const { children, ...current } = obj;
			flatArray.push(current);

			// Recurse through children if they exist
			if (children && Array.isArray(children)) {
				children.forEach(child => recursiveFlatten(child));
			}
		}

		// Start the recursive flattening for each root object
		input.forEach(item => recursiveFlatten(item));

		return flatArray;
	}

	useEffect(() => {
		var styleObjX = {};
		if (teamData?.loopLayout && teamData.loopLayout.length > 0) {
			const flatData = flattenObject(teamData.loopLayout);
			flatData.map(item => {
				var loopitemSelector = `${blockClass} #element-${item.id}`;
				var loopitemCss = generateElementCss(item, loopitemSelector);
				Object.entries(loopitemCss).map((selectors) => {
					var selector = selectors[0];
					var selectorData = selectors[1];
					styleObjX[selector] = selectorData;
				});
			})
		}

		var wrapperCss = generateElementCss(teamData.wrapper, wrapperSelector);
		Object.entries(wrapperCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});

		var itemsWrapCss = generateElementCss(teamData.itemsWrap, itemsWrapSelector);
		Object.entries(itemsWrapCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});
		var itemWrapCss = generateElementCss(teamData.itemWrap, itemWrapSelector);
		Object.entries(itemWrapCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});
		var nextCss = generateElementCss(teamData.next, nextSelector);
		Object.entries(nextCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});
		var nextIconCss = generateElementCss(teamData.nextIcon, nextIconSelector);
		Object.entries(nextIconCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});
		var prevCss = generateElementCss(teamData.prev, prevSelector);
		Object.entries(prevCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});
		var prevIconCss = generateElementCss(teamData.prevIcon, prevIconSelector);
		Object.entries(prevIconCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});
		var prevIconCss = generateElementCss(teamData.prevIcon, prevIconSelector);
		Object.entries(prevIconCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});
		var paginationWrapCss = generateElementCss(teamData.paginationWrap, paginationWrapSelector);
		Object.entries(paginationWrapCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});
		var paginationItemCss = generateElementCss(teamData.paginationItem, paginationItemSelector);
		Object.entries(paginationItemCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});
		var paginationItemActiveCss = generateElementCss(teamData.paginationItemActive, paginationItemActiveSelector);
		Object.entries(paginationItemActiveCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});

		var itemWrapCss = generateElementCss(teamData.itemWrap, itemWrapSelector);
		Object.entries(itemWrapCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});





		var navsWrapCss = generateElementCss(teamData.navsWrap, navsWrapSelector);
		Object.entries(navsWrapCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});

		var navItemCss = generateElementCss(teamData.navItem, navItemSelector);
		Object.entries(navItemCss).map((selectors) => {
			var selector = selectors[0];
			var selectorData = selectors[1];
			styleObjX[selector] = selectorData;
		});




		setstyleObj(styleObjX)



	}, [teamData]);









	return (
		<div className="ml-5">


		</div>
	);
}

class GenerateCss extends Component {
	constructor(props) {
		super(props);
		this.state = { showWarning: true };
		this.handleToggleClick = this.handleToggleClick.bind(this);
	}

	handleToggleClick() {
		this.setState((state) => ({
			showWarning: !state.showWarning,
		}));
	}


	render() {
		var { postData, onChange } = this.props;

		return (
			<Html
				postData={postData}
				onChange={onChange}
				warn={this.state.showWarning}
			/>
		);
	}
}

export default GenerateCss;
