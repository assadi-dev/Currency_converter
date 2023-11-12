import { LinksType, MetaType } from "./ApiServerRessponse.type";

export type CurrencyType = {
  id?: number;
  code?: string;
  name?: string;
  count?: number;
  created_at?: any;
  updated_at?: any;
};

export type CurrencyWithoutId = Omit<CurrencyType, "id">;

export type ApiCurrencySuccess = {
  data: CurrencyType[];
  links:LinksType
  meta:MetaType
};

export type CurrencyList = {
  id?: number;
  code?: string;
  name?: string;
  count?: number;
  toCurrencyAvailable?: Omit<CurrencyType,"created_at"|"updated_at">[]
} ;

export type ApiCurrencyListSuccess = {
  data: CurrencyList[];
};

export type ApiConvertSuccess = {
  data: {
    message: string;
    from: string;
    to: string;
    result: number;
    pairCurrency: number;
  };
};
