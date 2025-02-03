import { ToggleControl } from "@wordpress/components";
import { __ } from "@wordpress/i18n";
import React from "react";

const InputToggle = ({ label, value, onChange }) => {
	return (
		<div className="flex items-center gap-2 justify-between ">
			<span>
				{value
					? __("Enabled.", "team")
					: __("Disabled.", "team")}
			</span>
			<ToggleControl
				// help={value ? __("Enabled", "team") : __("Disabled.", "team")}
				checked={value ? true : false}
				onChange={(e) => {
					onChange(!value);
				}}
			/>
		</div>
	);
};

export default InputToggle;
