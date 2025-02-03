import React, { useEffect, useState } from "react";
import {
	ColorPalette,
	ToggleControl,
	PanelRow,
	SelectControl,
	Popover,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import colorsPresets from "../../../colors-presets";

const PgCSSBackgroundColor = ({ val, onChange, breakPoint, sudoSrc }) => {
	const [valArgs, setValArgs] = useState(val.split(" "));
	const [align, setalign] = useState(valArgs[0]);
	const [isImportant, setImportant] = useState(
		valArgs[1] == undefined ? false : true
	);
	const [customColor, setCustomColor] = useState([]);
	const [newColorPreset, setNewColorPreset] = useState([]);
	const [widthGlobal, setwidthGlobal] = useState("");
	useEffect(() => {
		if (window.postGridBlockEditor.colors != undefined) {
			setCustomColor(window.postGridBlockEditor.colors);
		}
	}, [window.postGridBlockEditor]);
	useEffect(() => {
		const transformedColors = customColor.map((color, index) => {
			const name = color.substring(1).toUpperCase();
			const upperCaseColor = color.toUpperCase();
			return {
				name,
				color: upperCaseColor,
			};
		});
		let newColor;
		if (transformedColors.length >= 6) {
			newColor = transformedColors;
		} else {
			newColor = transformedColors.concat(
				colorsPresets.slice(0, 6 - transformedColors.length)
			);
		}
		setNewColorPreset(newColor);
	}, [customColor]);
	useEffect(() => {
		setValArgs(val.split(" "));
		if (
			val === "inherit" ||
			val === "initial" ||
			val === "revert" ||
			val === "revert-layer" ||
			val === "unset"
		) {
			setwidthGlobal(val);
		} else {
			setwidthGlobal("");
		}
	}, [val, breakPoint, sudoSrc]);
	useEffect(() => {
		setalign(valArgs[0]);
		setImportant(valArgs[1] == undefined ? false : true);
	}, [valArgs]);
	return (
		<div className="relative">
			<div className="flex items-start justify-between">
				<label htmlFor="background-color">Background Color</label>
			</div>
			<div className={"w-full  pg-color-palette"}>
				<ColorPalette
					value={align}
					colors={newColorPreset}
					enableAlpha
					onChange={(newVal) => {
						//props.onChange(sudoSrc,newVal, 'color');
						setalign(newVal);
						if (isImportant) {
							onChange(newVal + " !important", "backgroundColor");
						} else {
							onChange(newVal, "backgroundColor");
						}
					}}
				/>
				<div className="flex items-start justify-between gap-1 mt-3">
					<div className="flex gap-1 items-center">
						<label htmlFor="" className="!mr-0 !font-normal">
							{__("Global Value", "team")}
						</label>
						<SelectControl
							label=""
							value={widthGlobal}
							options={[
								{ label: __("Choose", "team"), value: "" },
								{ label: "Inherit", value: "inherit" },
								{ label: "Initial", value: "initial" },
								{ label: "Revert", value: "revert" },
								{ label: "Revert-layer", value: "revert-layer" },
								{ label: "Unset", value: "unset" },
							]}
							onChange={(newVal) => {
								// setwidthUnit(newVal);
								setwidthGlobal(newVal);
								if (isImportant) {
									onChange(newVal + " !important", "backgroundColor");
								} else {
									onChange(newVal, "backgroundColor");
								}
							}}
						/>
					</div>
					<ToggleControl
						help={
							isImportant
								? __("(Enabled)", "team")
								: __("Important?", "team")
						}
						checked={isImportant}
						onChange={(arg) => {
							setImportant((isImportant) => !isImportant);
							if (isImportant) {
								onChange(align, "backgroundColor");
							} else {
								onChange(align + " !important", "backgroundColor");
							}
						}}
					/>
				</div>
			</div>
		</div>
	);
};

export default PgCSSBackgroundColor;
