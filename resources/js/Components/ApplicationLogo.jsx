import {FontAwesomeIcon} from "@fortawesome/react-fontawesome";
import { faBalanceScale } from "@fortawesome/free-solid-svg-icons";

export default function ApplicationLogo(props) {
    return (
        <div {...props}>
            <FontAwesomeIcon icon={faBalanceScale} className="w-10 h-10 text-gray-600"/>
        </div>
    );
}
