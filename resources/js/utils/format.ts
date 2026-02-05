export function formatDateBr(date: string | Date | null | undefined): string {
    if (!date) return '';

    const d = date instanceof Date ? date : new Date(date);
    if (isNaN(d.getTime())) return '';

    return d.toLocaleDateString('pt-BR');
}

export function padLeft(
    value: string | number | undefined,
    length: number,
    char: string = '0'
): string {
    return String(value).padStart(length, char);
}

export function getFirstLetter(value:string){
    return value.charAt(0)
}
