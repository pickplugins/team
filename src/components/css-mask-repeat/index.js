const { Component, RawHTML } = wp.element;
import { __ } from "@wordpress/i18n";
import { Button, Dropdown, ToggleControl } from "@wordpress/components";
import { useState } from "@wordpress/element";
function Html(props) {
	if (!props.warn) {
		return null;
	}
	var args = {
		repeat: { label: "Repeat", value: "repeat" },
		"repeat-x": { label: "Repeat X", value: "repeat-x" },
		"repeat-y": { label: "Repeat Y", value: "repeat-y" },
		"no-repeat": { label: "No repeat", value: "no-repeat" },
		space: { label: "Space", value: "space" },
		round: { label: "Round", value: "round" },
		inherit: { label: "inherit", value: "inherit" },
		initial: { label: "initial", value: "initial" },
		revert: { label: "revert", value: "revert" },
		unset: { label: "unset", value: "unset" },
	};
	const [valArgs, setValArgs] = useState(props.val.split(" "));
	const [align, setalign] = useState(valArgs[0]);
	const [isImportant, setImportant] = useState(
		valArgs[1] == undefined ? false : true
	);
	return (
		<div className="flex justify-between items-center">
			<Dropdown
				position="bottom"
				renderToggle={({ isOpen, onToggle }) => (
					<Button
						title={__("Background Repeat", "team")}
						onClick={onToggle}
						aria-expanded={isOpen}>
						{/* <div className=" ">{val ? args[val].label : 'Select...'}</div> */}
						<div className=" ">
							{args[align] == undefined
								? __("Select...", "team")
								: args[align].label}
						</div>
					</Button>
				)}
				renderContent={() => (
					<div className="w-32">
						{Object.entries(args).map((args) => {
							var index = args[0];
							var x = args[1];
							return (
								<div
									className={
										"px-3 py-1 border-b block hover:bg-gray-400 cursor-pointer"
									}
									onClick={(ev) => {
										// onChange(x.value, 'maskRepeat');
										setalign(x.value);
										if (isImportant) {
											props.onChange(x.value + " !important", "maskRepeat");
										} else {
											props.onChange(x.value, "maskRepeat");
										}
									}}>
									{!x.value && <div>{__("Reset", "team")}</div>}
									{x.value && <>{x.label}</>}
								</div>
							);
						})}
					</div>
				)}
			/>
			<ToggleControl
				help={
					isImportant
						? __("Important (Enabled)", "team")
						: __("Important?", "team")
				}
				checked={isImportant}
				onChange={(arg) => {
					setImportant((isImportant) => !isImportant);
					if (isImportant) {
						props.onChange(align, "backgroundRepeat");
					} else {
						props.onChange(align + " !important", "maskRepeat");
					}
				}}
			/>
		</div>
	);
}
class PGcssMaskRepeat extends Component {
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
		const { val, onChange } = this.props;
		return <Html val={val} onChange={onChange} warn={this.state.showWarning} />;
	}
}
export default PGcssMaskRepeat;
