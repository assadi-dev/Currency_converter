import { LinksType, MetaType } from "./ApiServerRessponse.type";

export type PairCurrencyType = {
  id?: number;
  codeFromCurrency?: string;
  nameFromCurrency?: string;
  codeToCurrency?: string;
  nameToCurrency?: string;
  exchange_rate?: number;
  count?: number;
};



export type ApiPairCurrencySuccess = {
  data: PairCurrencyType[]
  links:LinksType
  meta:MetaType
};

export type PairCurrencyTypeWithoutId = Omit<PairCurrencyType, "id">


