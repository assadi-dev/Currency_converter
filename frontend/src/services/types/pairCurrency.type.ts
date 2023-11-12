export type PairCurrencyType = {
  id?: number;
  codeFromCurrency?: string;
  nameFromCurrency?: string;
  codeToCurrency?: string;
  nameToCurrency?: string;
  exchange_rate?: number;
  count?: number;
};

type LinksType = {
  first: string|null
  last:string|null
  prev:string|null
  next:string | null
}

type LinksMeta = {
  url: string | null
  label: string
  active: boolean
}


type MetaType = {
  current_page: number
  from: number
  last_page: number
  links: LinksMeta[]
  path: string,
  per_page: number
  to: number,
  total: number
}

export type ApiPairCurrencySuccess = {
  data: PairCurrencyType[]
  links:LinksType
  meta:MetaType
};

export type PairCurrencyTypeWithoutId = Omit<PairCurrencyType, "id">


