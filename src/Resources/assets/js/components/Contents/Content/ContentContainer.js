import React, { Component } from 'react';
import { render } from 'react-dom';
import { connect } from 'react-redux';
import { DragDropContextProvider } from 'react-dnd';
import HTML5Backend from 'react-dnd-html5-backend';

import ContentBar from './ContentBar';
import ContentSidebar from './ContentSidebar';
import ContentFields from './ContentFields';
import MediaSelectModal from './../../Medias/MediaSelectModal';
import ContentSelectModal from './../ContentSelectModal';

import {
    cancelImage, updateImage,
    updateSelectedContent, cancelContent
} from './../actions/';

class ContentContainer extends Component {

    constructor(props) {
        super(props);
    }

    handleImageSelected(media) {
        this.props.updateImage(
            this.props.images.sourceField,
            media,
            this.props.app.fields,
            this.props.images.sourceLanguage
        );
    }

    handleImageCancel() {
        this.props.cancelImage();
    }

    handleContentSelected(content) {
        this.props.updateSelectedContent(
            this.props.contents.sourceField,
            content,
            this.props.app.fields
        );
    }

    handleContentCancel() {
        this.props.cancelContent();
    }

    render() {
        const fields = this.props.app.fields;
        const contentSourceField = this.props.contents.sourceField;
        
        const mediaType = this.props.images.sourceField != null 
            ? this.props.images.sourceField.type 
            : null;

        return (
            <div>
                <MediaSelectModal
                    display={this.props.images.displayModal}
                    field={this.props.images.sourceField}
                    mediaType={mediaType}
                    onImageSelected={this.handleImageSelected.bind(this)}
                    onImageCancel={this.handleImageCancel.bind(this)}
                />

                <ContentSelectModal
                    display={this.props.contents.displayModal}
                    field={contentSourceField != null && fields != null ? fields[contentSourceField] : null}
                    onContentSelected={this.handleContentSelected.bind(this)}
                    onContentCancel={this.handleContentCancel.bind(this)}
                />

                <ContentBar />

                <div className="container rightbar-page content">
                    <ContentSidebar />
                    <div className="col-xs-9 page-content">
                        <DragDropContextProvider backend={HTML5Backend}>
                            {this.props.app.errors &&
                                <ContentFields />
                            }
                        </DragDropContextProvider>
                    </div>
                </div>
            </div>
        );
    }

}


const mapStateToProps = state => {
    return {
        app: state.app,
        images: state.images,
        contents: state.contents
    }
}

const mapDispatchToProps = dispatch => {
    return {
        cancelImage: () => {
            return dispatch(cancelImage());
        },
        updateImage: (field, media, fields, language) => {
            return dispatch(updateImage(field, media, fields, language));
        },
        cancelContent: () => {
            return dispatch(cancelContent());
        },
        updateSelectedContent: (field, content, fields) => {
            return dispatch(updateSelectedContent(field, content, fields));
        }
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(ContentContainer);
