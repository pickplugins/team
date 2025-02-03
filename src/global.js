const { addFilter } = wp.hooks;
import { __ } from "@wordpress/i18n";
const { Component, useState, useEffect } = wp.element;
import apiFetch from "@wordpress/api-fetch";



//var [customerData, setcustomerData] = useState({ id: "", isPro: false });



apiFetch({
	path: "/team/v2/get_options",
	method: "POST",
	data: { option: "team_settings" },
}).then((res) => {
	if (res.length != 0) {
		var resX = { ...res };


		if (resX?.license_key) {
			//setcustomerData({ ...customerData, isPro: true })



			const sudoScourceArgsPro = {
				styles: { label: "Idle", value: "styles" },
				hover: { label: "Hover", value: "hover" },
				after: { label: "After", value: "after" },
				before: { label: "Before", value: "before" },
				active: { label: "Active", value: "active" },
				focus: { label: "Focus", value: "focus" },
				"focus-within": {
					label: "Focus-within",
					value: "focus-within",
				},
				target: { label: "target", value: "target" },
				visited: { label: "Visited", value: "visited" },
				selection: { label: "Selection", value: "selection" },
				":marker": { label: "Marker", value: ":marker" },
				"nth-child(even)": {
					label: "nth-child(even)",
					value: "nth-child(even)",
				},
				"nth-child(odd)": {
					label: "nth-child(odd)",
					value: "nth-child(odd)",
				},
				"nth-child(1)": {
					label: "nth-child(1)",
					value: "nth-child(1)",
				},
				"nth-child(2)": {
					label: "nth-child(2)",
					value: "nth-child(2)",
				},
				"nth-child(3)": {
					label: "nth-child(3)",
					value: "nth-child(3)",
				},
				"nth-child(4)": {
					label: "nth-child(4)",
					value: "nth-child(4)",
				},
				"nth-child(5)": {
					label: "nth-child(5)",
					value: "nth-child(5)",
				},

				"first-child": { label: "First-child", value: "first-child" },
				"last-child": { label: "Last-child", value: "last-child" },
				"first-letter": {
					label: "First-letter",
					value: "first-letter",
				},
				"first-line": { label: "First-line", value: "first-line" },
				"hover::before": { label: "hover::before", value: "hover::before" },
				"hover::after": { label: "hover::after", value: "hover::after" },
				"hover::marker": {
					label: "hover::marker",
					value: "hover::marker",
				},
				"hover::first-letter": {
					label: "hover::first-letter",
					value: "hover::first-letter",
				},
				"hover:first-child": {
					label: "hover:first-child",
					value: "hover:first-child",
				},
				"hover:last-child": {
					label: "hover:last-child",
					value: "hover:last-child",
				},
				"hover:first-line": {
					label: "hover:first-line",
					value: "hover:first-line",
				},
				"hover:first-line": {
					label: "hover:first-line",
					value: "hover:first-line",
				},
				"hover:nth-child(odd)": {
					label: "hover:nth-child(odd)",
					value: "hover:nth-child(odd)",
				},
				"hover:nth-child(even)": {
					label: "hover:nth-child(even)",
					value: "hover:nth-child(even)",
				},
				"hover div:nth-child(1)": {
					label: "hover div:nth-child(1)",
					value: "hover div:nth-child(1)",
				},
				"hover div:nth-child(2)": {
					label: "hover div:nth-child(2)",
					value: "hover div:nth-child(2)",
				},

				"-webkit-slider-thumb": {
					label: "-webkit-slider-thumb",
					value: "-webkit-slider-thumb",
				},
				"-moz-range-thumb": {
					label: "-moz-range-thumb",
					value: "-moz-range-thumb",
				},
				checked: { label: "checked", value: "checked" },
				"checked:after": {
					label: "checked:after",
					value: "checked:after",
				},
				"checked:before": {
					label: "checked:before",
					value: "checked:before",
				},
				"has(> input:checked)": {
					label: "has(> input:checked)",
					value: "has(> input:checked)",

				},
				"has(> input[type=radio]:checked)": {
					label: "has(> input[type=radio]:checked)",
					value: "has(> input[type=radio]:checked)",

				},
				"has(> input[type=checkbox]:checked)": {
					label: "has(> input[type=checkbox]:checked)",
					value: "has(> input[type=checkbox]:checked)",

				},
			};

			addFilter("sudoScourceArgs", "team/sudoScourceArgs", function (options) {
				return sudoScourceArgsPro;
			});


			var cssPropsPro = {
				alignContent: { id: "alignContent", label: "Align Content" },
				alignItems: { id: "alignItems", label: "Align Items" },
				alignSelf: { id: "alignSelf", label: "Align Self" },
				animationName: { id: "animationName", label: "Animation Name" },
				aspectRatio: { id: "aspectRatio", label: "Aspect Ratio" },
				backdropFilter: {
					id: "backdropFilter",
					label: "Backdrop Filter",
				},
				backfaceVisibility: {
					id: "backfaceVisibility",
					label: "Backface Visibility",
				},
				backgroundAttachment: {
					id: "backgroundAttachment",
					label: "Background Attachment",
				},
				backgroundBlendMode: {
					id: "backgroundBlendMode",
					label: "Background Blend Mode",
				},
				backgroundClip: {
					id: "backgroundClip",
					label: "Background Clip",
				},
				backgroundColor: { id: "backgroundColor", label: "Background Color" },
				backgroundImage: {
					id: "backgroundImage",
					label: "Background Image",
				},
				backgroundOrigin: { id: "backgroundOrigin", label: "Background Origin" },
				backgroundPosition: {
					id: "backgroundPosition",
					label: "Background Position",
				},
				backgroundRepeat: { id: "backgroundRepeat", label: "Background Repeat" },
				backgroundSize: { id: "backgroundSize", label: "Background Size" },
				border: { id: "border", label: "Border" },
				borderBottom: { id: "borderBottom", label: "Border Bottom" },
				borderCollapse: {
					id: "borderCollapse",
					label: "Border Collapse",
				},
				borderImage: { id: "borderImage", label: "Border Image" },
				borderLeft: { id: "borderLeft", label: "Border Left" },
				borderRadius: { id: "borderRadius", label: "Border Radius" },
				borderRight: { id: "borderRight", label: "Border Right" },
				borderSpacing: { id: "borderSpacing", label: "Border Spacing" },
				borderTop: { id: "borderTop", label: "Border Top" },
				bottom: { id: "bottom", label: "Bottom" },
				boxShadow: { id: "boxShadow", label: "Box Shadow" },
				boxSizing: { id: "boxSizing", label: "Box Sizing" },
				captionSide: { id: "captionSide", label: "Caption Side" },
				clear: { id: "clear", label: "Clear" },
				clip: { id: "clip", label: "Clip" },
				color: { id: "color", label: "Color" },
				columnCount: { id: "columnCount", label: "Column Count" },
				columnGap: { id: "columnGap", label: "Column gap" },
				columnRule: { id: "columnRule", label: "Column Rule" },
				content: { id: "content", label: "Content" },
				counterIncrement: {
					id: "counterIncrement",
					label: "Counter Increment",
				},
				counterReset: { id: "counterReset", label: "Counter Reset" },
				counterSet: { id: "counterSet", label: "Counter Set" },
				cursor: { id: "cursor", label: "Cursor" },
				direction: { id: "direction", label: "Direction" },
				display: { id: "display", label: "Display" },
				emptyCells: { id: "emptyCells", label: "Empty Cells" },
				filter: { id: "filter", label: "Filter" },
				flexBasis: { id: "flexBasis", label: "Flex Basis" },
				flexDirection: { id: "flexDirection", label: "Flex Direction" },
				flexFlow: { id: "flexFlow", label: "Flex Flow" },
				flexGrow: { id: "flexGrow", label: "Flex Grow" },
				flexShrink: { id: "flexShrink", label: "Flex Shrink" },
				flexWrap: { id: "flexWrap", label: "Flex Wrap" },
				float: { id: "float", label: "Float" },
				fontFamily: { id: "fontFamily", label: "Font Family" },
				fontSize: { id: "fontSize", label: "Font Size" },
				fontStretch: { id: "fontStretch", label: "Font Stretch" },
				fontStyle: { id: "fontStyle", label: "Font Style" },
				fontVariantCaps: {
					id: "fontVariantCaps",
					label: "Font VariantCaps",
				},
				fontWeight: { id: "fontWeight", label: "Font Weight" },
				gap: { id: "gap", label: "Gap" },
				gridAutoColumns: { id: "gridAutoColumns", label: "Grid Auto Columns" },
				gridAutoFlow: { id: "gridAutoFlow", label: "Grid Auto Flow" },
				gridColumnEnd: { id: "gridColumnEnd", label: "Grid Column End" },
				gridColumnStart: { id: "gridColumnStart", label: "Grid Column Start" },
				gridRowEnd: { id: "gridRowEnd", label: "Grid Row End" },
				gridRowStart: { id: "gridRowStart", label: "Grid Row Start" },
				gridTemplateColumns: {
					id: "gridTemplateColumns",
					label: "Grid Template Columns",
				},
				gridTemplateRows: { id: "gridTemplateRows", label: "Grid Template Rows" },
				height: { id: "height", label: "Height" },
				justifyContent: { id: "justifyContent", label: "Justify Content" },
				left: { id: "left", label: "Left" },
				letterSpacing: { id: "letterSpacing", label: "Letter Spacing" },
				lineHeight: { id: "lineHeight", label: "Line Height" },
				listStyle: { id: "listStyle", label: "List Style" },
				margin: { id: "margin", label: "Margin" },
				marginBottom: { id: "marginBottom", label: "Margin Bottom" },
				marginLeft: { id: "marginLeft", label: "Margin Left" },
				marginRight: { id: "marginRight", label: "Margin Right" },
				marginTop: { id: "marginTop", label: "Margin Top" },
				maskImage: {
					id: "maskImage",
					label: "Mask Image",
				},
				maskMode: {
					id: "maskMode",
					label: "Mask Mode",
				},
				maskOrigin: {
					id: "maskOrigin",
					label: "Mask Origin",
				},
				maskPosition: {
					id: "maskPosition",
					label: "Mask Position",
				},
				maskRepeat: {
					id: "maskRepeat",
					label: "Mask Repeat",
				},
				maskSize: {
					id: "maskSize",
					label: "Mask Size",
				},
				maxHeight: { id: "maxHeight", label: "Max Height" },
				maxWidth: { id: "maxWidth", label: "Max Width" },
				minHeight: { id: "minHeight", label: "Min Height" },
				minWidth: { id: "minWidth", label: "Min Width" },
				objectFit: { id: "objectFit", label: "Object Fit" },
				opacity: { id: "opacity", label: "Opacity" },
				order: { id: "order", label: "Order" },
				outline: { id: "outline", label: "Outline" },
				overflow: { id: "overflow", label: "Overflow" },
				overflowX: { id: "overflowX", label: "OverflowX" },
				overflowY: { id: "overflowY", label: "OverflowY" },
				padding: { id: "padding", label: "Padding" },
				paddingBottom: { id: "paddingBottom", label: "Padding Bottom" },
				paddingLeft: { id: "paddingLeft", label: "Padding Left" },
				paddingRight: { id: "paddingRight", label: "Padding Right" },
				paddingTop: { id: "paddingTop", label: "Padding Top" },
				perspective: { id: "perspective", label: "Perspective" },
				position: { id: "position", label: "Position" },
				right: { id: "right", label: "Right" },
				rowGap: { id: "rowGap", label: "Row Gap" },
				tableLayout: { id: "tableLayout", label: "Table Layout" },
				textAlign: { id: "textAlign", label: "Text Align" },
				textDecoration: {
					id: "textDecoration",
					label: "Text Decoration",
				},
				textIndent: { id: "textIndent", label: "Text Indent" },
				textJustify: { id: "textJustify", label: "Text Justify" },
				textOverflow: { id: "textOverflow", label: "Text Overflow" },
				textShadow: { id: "textShadow", label: "Text Shadow" },
				textTransform: { id: "textTransform", label: "Text Transform" },
				top: { id: "top", label: "Top" },
				transform: { id: "transform", label: "Transform" },
				transformOrigin: {
					id: "transformOrigin",
					label: "Transform Origin",
				},
				transformStyle: {
					id: "transformStyle",
					label: "Transform Style",
				},
				transition: { id: "transition", label: "Transition" },
				verticalAlign: { id: "verticalAlign", label: "Vertical Align" },
				visibility: { id: "visibility", label: "Visibility" },
				width: { id: "width", label: "Width" },
				wordBreak: { id: "wordBreak", label: "Word Break" },
				wordSpacing: { id: "wordSpacing", label: "Word Spacing" },
				wordWrap: { id: "wordWrap", label: "Word Wrap" },
				writingMode: { id: "writingMode", label: "Writing Mode" },
				zIndex: { id: "zIndex", label: "Z-Index" },
				"-webkit-text-fill-color": {
					id: "-webkit-text-fill-color",
					label: "Webkit Text Fill Color",
				},
			};

			addFilter("cssProps", "post-grid/cssProps", function (options) {
				return cssPropsPro;
			});





		}
	}
});






