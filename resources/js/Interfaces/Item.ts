export default interface Item {
    id?: string | Number,
    text: string | Number,
    value: string,
    bold?: boolean,
    italic?: boolean,
    clickable?: boolean,
    eventToEmit?: string,
}
