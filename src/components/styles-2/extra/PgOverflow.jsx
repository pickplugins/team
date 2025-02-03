import React, { useEffect, useState } from "react";
import { ToggleControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";

const PgCSSOverflow = ({ val, onChange, breakPoint, sudoSrc }) => {
	var args = {
		scroll: { label: "Scroll", value: "scroll" },
		hidden: { label: "Hidden", value: "hidden" },
		auto: { label: "Auto", value: "auto" },
		clip: { label: "Clip", value: "clip" },
		visible: { label: "Visible", value: "visible" },
	};
	const [valArgs, setValArgs] = useState(val.split(" "));
	const [align, setalign] = useState(valArgs[0]);
	const [isImportant, setImportant] = useState(
		valArgs[1] == undefined ? false : true
	);
	useEffect(() => {
		setValArgs(val.split(" "));
	}, [val, breakPoint, sudoSrc]);
	useEffect(() => {
		setalign(valArgs[0]);
		setImportant(valArgs[1] == undefined ? false : true);
	}, [valArgs]);
	return (
		<div className="w-full flex flex-col items-start gap-1">
			<label htmlFor="overflow" className="flex-1">
				Overflow
			</label>
			<div className="flex items-start justify-between gap-1 w-full">
				<select
					value={align}
					onChange={(ev) => {
						const selectedValue = ev.target.value;
						if (isImportant) {
							onChange(selectedValue + " !important", "overflow");
						} else {
							onChange(selectedValue, "overflow");
						}
						setalign(selectedValue);
					}}>
					{Object.entries(args).map((item, i) => {
						var x = item[1];
						return (
							<option key={i} value={x.value}>
								{x.label}
							</option>
						);
					})}
				</select>
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
							onChange(align, "overflow");
						} else {
							onChange(align + " !important", "overflow");
						}
					}}
				/>
			</div>
		</div>
	);
};

export default PgCSSOverflow;
