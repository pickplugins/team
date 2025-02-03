import { close, Icon, pages } from '@wordpress/icons';
import React from 'react'
import { ReactSortable } from 'react-sortablejs';

const sortableOptions = {
	animation: 150,
	fallbackOnBody: true,
	swapThreshold: 0.65,
	ghostClass: "ghost",
	group: "shared",
};

const TreeView = ({ blocks, setBlocks, selected, setSelected }) => {
	return (
		<div>

			<div className='flex items-center justify-between bg-slate-400 px-3 py-2'>

				<div className='text-[20px] font-bold'>Tree View</div>
				<span className='hover:bg-red-500 bg-slate-700 text-white px-5 py-2 rounded-sm cursor-pointer ' onClick={() => setBlocks([{
					id: 1,
					type: "root",
					children: [],
					parent_id: null,
					styles: {}
				}])}>Remove All {" "} </span>
			</div>



			<div className='p-2'>
				<ReactSortable list={blocks} setList={setBlocks} {...sortableOptions}>
					{blocks.map((block, blockIndex) => (
						<BlockWrapper
							key={block.id}
							block={block}
							blockIndex={[blockIndex]}
							setBlocks={setBlocks}
							selected={selected}
							setSelected={setSelected}
						/>
					))}
				</ReactSortable>
			</div>



		</div>
	);
}

function Container({ block, blockIndex, setBlocks, selected, setSelected }) {
	return (
		<>
			<ReactSortable
				key={block.id}
				list={block.children}
				setList={(currentList) => {
					setBlocks((sourceList) => {
						const tempList = [...sourceList];
						const _blockIndex = [...blockIndex];
						const lastIndex = _blockIndex.pop();
						const lastArr = _blockIndex.reduce(
							(arr, i) => arr[i]["children"],
							tempList
						);
						lastArr[lastIndex]["children"] = currentList;
						return tempList;
					});
				}}
				{...sortableOptions}>
				{block.children &&
					block.children.map((childBlock, index) => {
						return (
							<BlockWrapper
								key={childBlock.id}
								block={childBlock}
								blockIndex={[...blockIndex, index]}
								setBlocks={setBlocks}
								selected={selected}
								setSelected={setSelected}
							/>
						);
					})}
			</ReactSortable>
		</>
	);
}
function BlockWrapper({ block, blockIndex, setBlocks, selected, setSelected }) {
	if (!block) return null;
	const handleRemove = () => {
		if (block.type == "root") {
			return
		}
		setBlocks((prev) => {
			const updatedBlocks = [...prev];
			removeNestedBlock(updatedBlocks, blockIndex);
			return updatedBlocks;
		});
	};

	const handleDuplicate = () => {
		setBlocks((prev) => {
			const updatedBlocks = [...prev];
			const duplicateBlock = (block) => {
				// Create a deep clone of the block with a new ID
				const newBlock = {
					...block,
					id: Date.now() + Math.random(), // Ensure a unique ID
					children: block.children ? block.children.map(duplicateBlock) : [], // Recursively duplicate children
				};
				return newBlock;
			};

			const parentBlock = getNestedBlock(
				updatedBlocks,
				blockIndex.slice(0, -1)
			);
			const newBlock = duplicateBlock(block);

			if (blockIndex.length === 1) {
				// If the block is at the root level
				updatedBlocks.splice(blockIndex[0] + 1, 0, newBlock);
			} else {
				// If the block is nested
				parentBlock.children.splice(
					blockIndex[blockIndex.length - 1] + 1,
					0,
					newBlock
				);
			}

			return updatedBlocks;
		});
	};




	return (
		<div className="block relative my-2 border-0 border-l border-solid pl-2">
			<div
				className={`flex items-center border border-solid px-2 py-1 cursor-pointer hover:bg-gray-300 ${block.id == selected ? "bg-gray-300" : ""
					} `}
				onClick={() => setSelected(block.id)}>
				<span className="flex-1 overflow-hidden truncate text-md">
					{block.type}
				</span>
				<div className="flex items-center gap-2">
					<span
						className="size-6 bg-red-500 flex items-center justify-center cursor-pointer"
						onClick={handleRemove}>
						<Icon icon={close} size={18} />
					</span>
					<span
						className="size-6 bg-blue-300 flex items-center justify-center cursor-pointer"
						onClick={handleDuplicate}>
						<Icon icon={pages} size={18} />
					</span>
				</div>
			</div>
			{["root", "container"].includes(block.type) && (
				<Container
					block={block}
					setBlocks={setBlocks}
					blockIndex={blockIndex}
					selected={selected}
					setSelected={setSelected}
				/>
			)}
		</div>
	);



}

function getNestedBlock(blocks, indices) {
	return indices.reduce((block, index) => block.children[index], {
		children: blocks,
	});
}

function removeNestedBlock(blocks, indices) {
	if (indices.length === 1) {
		blocks.splice(indices[0], 1);
	} else {
		const parentBlock = getNestedBlock(blocks, indices.slice(0, -1));
		parentBlock.children.splice(indices[indices.length - 1], 1);
	}
}

export default TreeView