
/**
 * Formulaire de paire de conversion
 */

import { PairCurrencyType } from "./pairCurrency.type";

export type PairCurrencyFormValue = Omit<PairCurrencyType,"id" | "count">
