import { Component } from "../widgets/component";
import { RowNode } from "../entities/rowNode";
import { Column } from "../entities/column";
export declare class DndSourceComp extends Component {
    private readonly rowNode;
    private readonly column;
    private readonly eCell;
    constructor(rowNode: RowNode, column: Column, eCell: HTMLElement);
    private postConstruct;
    private addDragSource;
    private onDragStart;
    private checkVisibility;
}
