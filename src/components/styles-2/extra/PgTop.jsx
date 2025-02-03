import React, { useEffect, useState } from "react";
import {
	Button,
	Dropdown,
	ToggleControl,
	__experimentalInputControl as InputControl,
} from "@wordpress/components";
import { __ } from "@wordpress/i18n";

const PgCSSTop = ({ val, onChange, breakPoint, sudoSrc }) => {
	var args = {
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

	var valZ = typeof val === "object" ? val.target.value : val;
	var valX =
		valZ == undefined || valZ.match(/[+-]?([0-9]*[.])?[0-9]+/g) == null
			? 0
			: valZ.match(/[+-]?([0-9]*[.])?[0-9]+/g)[0];
	var unitX =
		valZ == undefined || valZ.match(/[a-zA-Z%]+/g) == null
			? "px"
			: valZ.match(/[a-zA-Z%]+/g)[0];
	const [valueX, setValueX] = useState(valX);
	const [unit, setUnit] = useState(unitX);
	useEffect(() => {
		setValueX(valX);
		setUnit(unitX);
	}, [val, breakPoint, sudoSrc]);
	const [isImportant, setImportant] = useState(
		valZ.includes(" !important") ? true : false
	);
	return (
		<div className="flex flex-col justify-between gap-1 items-start">
			<label htmlFor="top">Top</label>
			<div className="flex gap-1 w-full items-start justify-between">
				<div className="flex items-center gap-1">
					{unit != "auto" && (
						<InputControl
							className="w-16 !leading-3"
							id="font-size"
							value={valueX}
							type="number"
							step={0.01}
							disabled={unit === "auto" ? true : false}
							onChange={(newVal) => {
								var v = newVal;
								setValueX(v);
								if (unit == "auto") {
									if (isImportant) {
										onChange(unit + " !important", "top");
									} else {
										onChange(unit, "top");
									}
								} else {
									if (isImportant) {
										onChange(v + unit + " !important", "top");
									} else {
										onChange(v + unit, "top");
									}
								}
							}}
						/>
					)}
					<div>
						<select
							value={unit}
							onChange={(ev) => {
								const selectedValue = ev.target.value;
								setUnit(selectedValue);
								if (selectedValue == "auto") {
									if (isImportant) {
										onChange(selectedValue + " !important", "top");
									} else {
										onChange(selectedValue, "top");
									}
								} else {
									if (isImportant) {
										onChange(valueX + selectedValue + " !important", "top");
									} else {
										onChange(valueX + selectedValue, "top");
									}
								}
							}}>
							{Object.entries(args).map((y) => {
								var index = y[0];
								var x = y[1];
								return (
									<option key={index} value={x.value}>
										{x.label}
									</option>
								);
							})}
						</select>
					</div>
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
							if (unit == "auto") {
								onChange(unit, "top");
							} else {
								onChange(valueX + unit, "top");
							}
						} else {
							if (unit == "auto") {
								onChange(unit + " !important", "top");
							} else {
								onChange(valueX + unit + " !important", "top");
							}
						}
					}}
				/>
			</div>
		</div>
	);
};

export default PgCSSTop;
