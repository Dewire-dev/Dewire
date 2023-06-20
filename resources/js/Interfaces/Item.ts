export default interface Item {
    id?: string | Number,
    text: string | Number,
    value: string,
    bold?: boolean,
    italic?: boolean,
    clickableText?: boolean,
    clickableItem?: boolean,
    eventToEmit?: string,
    iconHoverAdd?: boolean,
    date?: string,
}
