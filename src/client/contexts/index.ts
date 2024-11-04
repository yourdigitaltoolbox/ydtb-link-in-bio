import { ReactNode } from "react";
// import OfferProvider from './Offer';
// import OfferWizardProvider from './OfferWizard';

export const Context = ({ children }: { children: ReactNode }) => {
  return (
    // <OfferProvider>
    //     <OfferWizardProvider>
    children
    //     </OfferWizardProvider>
    // </OfferProvider>
  );
};
