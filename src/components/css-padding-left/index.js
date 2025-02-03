const { Component } = wp.element;
import { __ } from "@wordpress/i18n";
import { Button, Dropdown, ToggleControl } from "@wordpress/components";
import { useState } from "@wordpress/element";
import {
	__experimentalInputControl as InputControl,
	ColorPalette,
} from "@wordpress/components";
function Html(props) {
	if (!props.warn) {
		return null;
	}
	var unitArgs = {
		px: { label: "PX", value: "px" },
		em: { label: "EM", value: "em" },
		rem: { label: "REM", value: "rem" },
		auto: { label: "AUTO", value: "auto" },
		"%": { label: "%", value: "%" },
		cm: { label: "CM", value: "cm" },
		mm: { label: "MM", value: "mm" },
		in: { label: "IN", value: "in" },
		pt: { label: "PT", value: "pt" },
		pc: { label: "PC", value: "pc" },
		ex: { label: "EX", value: "ex" },
		ch: { label: "CH", value: "ch" },
		vw: { label: "VW", value: "vw" },
		vh: { label: "VH", value: "vh" },
		vmin: { label: "VMIN", value: "vmin" },
		vmax: { label: "VMAX", value: "vmax" },
	};
	var valZ =
		props.val == null || props.val == undefined || props.val.length == 0
			? "0px"
			: props.val;
	var widthValX =
		valZ == undefined || valZ.match(/-?\d+/g) == null
			? 0
			: valZ.match(/-?\d+/g)[0];
	var widthUnitX =
		valZ == undefined || valZ.match(/[a-zA-Z%]+/g) == null
			? "px"
			: valZ.match(/[a-zA-Z%]+/g)[0];
	const [widthVal, setwidthVal] = useState(widthValX);
	const [widthUnit, setwidthUnit] = useState(widthUnitX);
	const [isImportant, setImportant] = useState(
		valZ.includes(" !important") ? true : false
	);
	return (
		<div className="flex justify-between">
			{widthUnit != "auto" && (
				<InputControl
					value={widthVal}
					type="number"
					disabled={widthUnit == "auto" ? true : false}
					onChange={(newVal) => {
						setwidthVal(newVal);
						if (widthUnit == "auto") {
							// props.onChange(widthUnit, 'width');
							if (isImportant) {
								props.onChange(widthUnit + " !important", "paddingLeft");
							} else {
								props.onChange(widthUnit, "paddingLeft");
							}
						} else {
							//props.onChange(newVal + widthUnit, 'width');
							if (isImportant) {
								props.onChange(
									newVal + widthUnit + " !important",
									"paddingLeft"
								);
							} else {
								props.onChange(newVal + widthUnit, "paddingLeft");
							}
						}
					}}
				/>
			)}
			<div>
				<Dropdown
					position="bottom left"
					renderToggle={({ isOpen, onToggle }) => (
						<Button title="" onClick={onToggle} aria-expanded={isOpen}>
							<div className=" ">
								{valZ
									? unitArgs[widthUnit].label
									: __("Select...", "team")}
							</div>
						</Button>
					)}
					renderContent={() => (
						<div className="w-32 pg-font">
							{Object.entries(unitArgs).map((y) => {
								var index = y[0];
								var x = y[1];
								return (
									<div
										className={
											"px-3 py-1 border-b block hover:bg-gray-400 cursor-pointer"
										}
										onClick={(ev) => {
											setwidthUnit(x.value);
											if (x.value == "auto") {
												if (isImportant) {
													props.onChange(
														x.value + " !important",
														"paddingLeft"
													);
												} else {
													props.onChange(x.value, "paddingLeft");
												}
											} else {
												if (isImportant) {
													props.onChange(
														widthVal + x.value + " !important",
														"paddingLeft"
													);
												} else {
													props.onChange(widthVal + x.value, "paddingLeft");
												}
											}
										}}>
										{x.value && <>{x.label}</>}
									</div>
								);
							})}
						</div>
					)}
				/>
			</div>
			<ToggleControl
				help={
					isImportant
						? __("Important Enabled", "team")
						: __("Important?", "team")
				}
				checked={isImportant}
				onChange={(arg) => {
					setImportant((isImportant) => !isImportant);
					if (isImportant) {
						if (widthUnit == "auto") {
							props.onChange(widthUnit, "paddingLeft");
						} else {
							props.onChange(widthVal + widthUnit, "paddingLeft");
						}
					} else {
						if (widthUnit == "auto") {
							props.onChange(widthUnit + " !important", "paddingLeft");
						} else {
							props.onChange(
								widthVal + widthUnit + " !important",
								"paddingLeft"
							);
						}
					}
				}}
			/>
		</div>
	);
}
class PGcssPaddingLeft extends Component {
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
		var { val, onChange } = this.props;
		return <Html val={val} onChange={onChange} warn={this.state.showWarning} />;
	}
}
export default PGcssPaddingLeft;
